
<section class="job-listings | grid">
    <div class="job-listings__header">
        <h3>Click on the drop-downs below to refine your search</h3>
    </div>
    <div class="job-listings__filters">
        <select class="job-listings__filter job-listings__filter--practice" id="practiceFilter">
            <option value="">All Practices</option>
        </select>
    
        <select class="job-listings__filter job-listings__filter--location" id="locationFilter">
            <option value="">All Locations</option>
            <?php if(have_rows('locations')): while(have_rows('locations')): the_row(); ?>
                <?php 
                    $label = get_sub_field('label');
                    $value = get_sub_field('greenhouse');
                ?>

                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>

            <?php endwhile; endif; ?>
        </select>

        <div class="job-listings__clear">
            <a href="#" class="job-listings__clear-link">x Clear Filters</a>
        </div>
    </div>
    <div class="job-listings__list" id="jobList"></div>
</section>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const locationFilter = document.getElementById('locationFilter');
    const practiceFilter = document.getElementById('practiceFilter');
    const jobList = document.getElementById('jobList');
    const clearFiltersLink = document.querySelector(".job-listings__clear-link");

    const JOBS_API_URL = 'https://api.greenhouse.io/v1/boards/environmentalscienceassociates/jobs?content=true';
    const PRACTICES_API_URL = 'https://api.greenhouse.io/v1/boards/environmentalscienceassociates/departments?render_as=tree';

    let allJobs = [];
    let parentDepartmentsMap = {};
    const INTERNAL_PRACTICE_ID = 4010536008;
    const CACHE_VER = 1;
    let pendingFetches = 0;

    // Dictionary to map office values to labels
    const officeLabels = {};
    <?php if(have_rows('locations')): while(have_rows('locations')): the_row(); ?>
        officeLabels['<?php echo get_sub_field('greenhouse'); ?>'] = '<?php echo get_sub_field('label'); ?>';
    <?php endwhile; endif; ?>

    // --- Helpers: caching, fetch, schema guards, UI state ---
    function setCache(key, value, ttlMs) {
        try {
            sessionStorage.setItem(key, JSON.stringify({ ver: CACHE_VER, ts: Date.now(), ttl: ttlMs, data: value }));
        } catch (e) {
            // no-op
        }
    }

    function getCache(key) {
        try {
            const raw = sessionStorage.getItem(key);
            if (!raw) return null;
            const obj = JSON.parse(raw);
            if (!obj || obj.ver !== CACHE_VER) return null;
            if (obj.ttl && Date.now() - obj.ts > obj.ttl) return null;
            return obj.data;
        } catch (e) {
            return null;
        }
    }

    async function fetchJsonWithRetry(url, { retries = 2, timeoutMs = 8000, signal } = {}) {
        let lastErr;
        for (let attempt = 0; attempt <= retries; attempt++) {
            const controller = new AbortController();
            const timer = setTimeout(() => controller.abort(), timeoutMs);
            try {
                const res = await fetch(url, { signal: signal || controller.signal });
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                const ct = res.headers.get('content-type') || '';
                if (!ct.includes('application/json')) throw new Error('Unexpected content-type');
                return await res.json();
            } catch (e) {
                lastErr = e;
            } finally {
                clearTimeout(timer);
            }
        }
        throw lastErr;
    }

    function isDepartmentsPayload(v) { return v && Array.isArray(v.departments); }
    function isJobsPayload(v) { return v && Array.isArray(v.jobs); }

    function setFiltersDisabled(disabled) {
        if (practiceFilter) practiceFilter.disabled = disabled;
        if (locationFilter) locationFilter.disabled = disabled;
    }

    function showLoading() {
        jobList.innerHTML = '<div class="loading"><p>Loading job listings…</p></div>';
    }

    function showError(message) {
        jobList.textContent = '';
        const div = document.createElement('div');
        div.className = 'load-error';
        const p = document.createElement('p');
        p.textContent = message;
        div.appendChild(p);
        jobList.appendChild(div);
    }

    function removeDepartmentByIdDeep(data, id) {
        const src = data && Array.isArray(data.departments) ? data.departments : [];
        const cleaned = src
            .filter(d => d && d.id !== id)
            .map(d => ({
                id: d.id,
                name: d.name,
                children: Array.isArray(d.children) ? d.children.filter(c => c && c.id !== id) : [],
                jobs: Array.isArray(d.jobs) ? d.jobs : []
            }));
        return { departments: cleaned };
    }

    async function fetchJobs() {
        pendingFetches++;
        setFiltersDisabled(true);
        if (!getCache('jobsData')) {
            showLoading();
        }
        try {
            const data = await fetchJsonWithRetry(JOBS_API_URL, { retries: 2, timeoutMs: 8000 });
            if (!isJobsPayload(data)) throw new Error('Unexpected jobs payload');
            setCache('jobsData', data, 15 * 60 * 1000);
            buildAllJobs(data);
        } catch (error) {
            console.error('Error fetching jobs:', error);
            const cached = getCache('jobsData');
            if (cached && isJobsPayload(cached)) {
                buildAllJobs(cached);
            } else {
                showError('Unable to load job listings. Please try again later.');
            }
        } finally {
            pendingFetches--;
            if (pendingFetches === 0) setFiltersDisabled(false);
        }
    }

    async function fetchPractices() {
        pendingFetches++;
        setFiltersDisabled(true);
        try {
            let data = await fetchJsonWithRetry(PRACTICES_API_URL, { retries: 2, timeoutMs: 8000 });
            if (!isDepartmentsPayload(data)) throw new Error('Unexpected departments payload');
            data = removeDepartmentByIdDeep(data, INTERNAL_PRACTICE_ID);
            setCache('practicesData', data, 60 * 60 * 1000);
            buildParentDepartmentsMap(data);
            populatePractices(data);
        } catch (error) {
            console.error('Error fetching practices:', error);
            const cached = getCache('practicesData');
            if (cached && isDepartmentsPayload(cached)) {
                buildParentDepartmentsMap(cached);
                populatePractices(cached);
            }
        } finally {
            pendingFetches--;
            if (pendingFetches === 0) setFiltersDisabled(false);
        }
    }

    function buildAllJobs(data) {
        if (!parentDepartmentsMap || Object.keys(parentDepartmentsMap).length === 0) {
            const practicesData = getCache('practicesData');
            if (practicesData) {
                buildParentDepartmentsMap(practicesData);
            } else {
                console.warn("Practices data is not available in sessionStorage.");
            }
        }

        allJobs = data.jobs.map((job) => {
            const department_parent_id = job.departments[0] ? String(job.departments[0].parent_id) : 'Unknown ID';
            const practice = parentDepartmentsMap[department_parent_id] || 'Unknown Practice';
            const locations = job.offices && job.offices.length > 0 ? job.offices.map(office => office.name) : ['Unknown Location'];
            
            return {
                title: job.title,
                url: job.absolute_url,
                locations: locations, // Changed from location to locations (array of all locations)
                department_parent_id: department_parent_id,
                practice: practice
            };
        });

        displayJobs(allJobs);
    }

    function buildParentDepartmentsMap(practicesData) {
        const src = practicesData || getCache('practicesData');
        if (!isDepartmentsPayload(src)) {
            return; // graceful no-op if data is missing or malformed
        }
        parentDepartmentsMap = {};
        src.departments.forEach(department => {
            parentDepartmentsMap[String(department.id)] = department.name; // Convert to string
        });
    }

    function populatePractices(practicesData) {
        const src = practicesData || getCache('practicesData');
        if (!isDepartmentsPayload(src)) {
            return; // nothing to render
        }

        practiceFilter.innerHTML = '<option value="">All Practices</option>'; // Reset options
        const uniqueMap = new Map();
        src.departments.forEach(department => {
            if (!uniqueMap.has(department.id)) uniqueMap.set(department.id, department);
        });
        const sorted = Array.from(uniqueMap.values()).sort((a, b) => String(a.name).localeCompare(String(b.name)));

        sorted.forEach(department => {
            const option = document.createElement('option');
            option.value = String(department.id); // Convert to string
            option.textContent = department.name;
            practiceFilter.appendChild(option);
        });
    }

    function displayJobs(jobs) {
        jobList.textContent = '';

        if (!Array.isArray(jobs) || jobs.length === 0) {
            const noRes = document.createElement('div');
            noRes.className = 'no-results';
            const p = document.createElement('p');
            p.textContent = 'No job listings match your criteria.';
            noRes.appendChild(p);
            jobList.appendChild(noRes);
            return;
        }

        jobs.forEach(job => {
            const normalizedLocations = Array.isArray(job.locations) ? job.locations.map(location => (officeLabels[location] || location)) : [];
            const jobLocation = normalizedLocations.join('; ');

            const wrapper = document.createElement('div');
            wrapper.className = 'job-listing';

            const h3 = document.createElement('h3');
            h3.className = 'job-listing__title';
            const a = document.createElement('a');
            a.href = job.url;
            a.target = '_blank';
            a.rel = 'noopener';
            a.textContent = job.title;
            h3.appendChild(a);

            const meta = document.createElement('p');
            meta.className = 'job-listing__meta';
            meta.innerHTML = `${job.practice} <span class="divider">|</span> ${jobLocation}`;

            wrapper.appendChild(h3);
            wrapper.appendChild(meta);

            jobList.appendChild(wrapper);
        });
    }

    function filterJobs() {
        const location = locationFilter.value;
        const practice = practiceFilter.value;

        let filteredJobs = allJobs;

        if (location) {
            const isRemoteName = function(n) { const s = (n || '').toLowerCase(); return s.includes('remote'); };
            if (location === "Remote") {
                filteredJobs = filteredJobs.filter(job => Array.isArray(job.locations) && job.locations.some(isRemoteName));
            } else {
                filteredJobs = filteredJobs.filter(job => Array.isArray(job.locations) && job.locations.includes(location));
            }
        }

        if (practice) {
            filteredJobs = filteredJobs.filter(job => job.department_parent_id === practice);
        }

        displayJobs(filteredJobs);
    }

    // Reset filters and fetch all jobs
    function resetFilters() {
        locationFilter.value = "";
        practiceFilter.value = "";
        displayJobs(allJobs);
    }

    // Event listeners
    locationFilter.addEventListener('change', filterJobs);
    practiceFilter.addEventListener('change', filterJobs);
    clearFiltersLink.addEventListener("click", function (event) {
        event.preventDefault();
        resetFilters();
    });

    // Check if jobs JSON is already stored (cache)
    (function initJobs() {
        const jobsData = getCache('jobsData');
        if (jobsData && isJobsPayload(jobsData)) {
            buildAllJobs(jobsData);
        } else {
            fetchJobs();
        }
    })();

    // Check if practices JSON is already stored (cache)
    (function initPractices() {
        const practicesData = getCache('practicesData');
        if (practicesData && isDepartmentsPayload(practicesData)) {
            buildParentDepartmentsMap(practicesData);
            populatePractices(practicesData);
        } else {
            fetchPractices();
        }
    })();
});

</script>