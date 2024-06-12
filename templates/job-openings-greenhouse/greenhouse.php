
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

    // Dictionary to map office values to labels
    const officeLabels = {};
    <?php if(have_rows('locations')): while(have_rows('locations')): the_row(); ?>
        officeLabels['<?php echo get_sub_field('greenhouse'); ?>'] = '<?php echo get_sub_field('label'); ?>';
    <?php endwhile; endif; ?>

    async function fetchJobs() {
        const response = await fetch(JOBS_API_URL);
        const data = await response.json();
        sessionStorage.setItem('jobsData', JSON.stringify(data)); // Save jobs JSON to sessionStorage
        buildAllJobs(data);
    }

    function buildAllJobs(data) {
        if (!parentDepartmentsMap || Object.keys(parentDepartmentsMap).length === 0) {
            const practicesData = JSON.parse(sessionStorage.getItem('practicesData'));
            if (practicesData) {
                buildParentDepartmentsMap(practicesData);
            } else {
                console.warn("Practices data is not available in sessionStorage.");
            }
        }

        allJobs = data.jobs.map((job) => {
            const department_parent_id = job.departments[0] ? String(job.departments[0].parent_id) : 'Unknown ID';
            const practice = parentDepartmentsMap[department_parent_id] || 'Unknown Practice';
            return {
                title: job.title,
                url: job.absolute_url,
                location: job.offices[0] ? job.offices[0].name : 'Unknown Location',
                department_parent_id: department_parent_id,
                practice: practice // Set the practice here
            };
        });

        displayJobs(allJobs);
    }

    async function fetchPractices() {
        const response = await fetch(PRACTICES_API_URL);
        const data = await response.json();
        sessionStorage.setItem('practicesData', JSON.stringify(data)); // Save practices JSON to sessionStorage
        buildParentDepartmentsMap(data);
        populatePractices(data.departments);
    }

    function buildParentDepartmentsMap(data) {
        data.departments.forEach(department => {
            parentDepartmentsMap[String(department.id)] = department.name; // Convert to string
        });
    }

    function populatePractices(departments) {
        practiceFilter.innerHTML = '<option value="">All Practices</option>'; // Reset options
        departments.forEach(department => {
            const option = document.createElement('option');
            option.value = String(department.id); // Convert to string
            option.textContent = department.name;
            practiceFilter.appendChild(option);
        });
    }

    function displayJobs(jobs) {
        jobList.innerHTML = '';

        if (jobs.length === 0) {
            jobList.innerHTML = `
                <div class="no-results">
                    <p>No job listings match your criteria.</p>
                </div>
            `;
            return;
        }

        jobs.forEach(job => {
            let jobLocation = '';
            if(job.location.includes("Remote")) {
                jobLocation += "Remote";
            } else {
                jobLocation += officeLabels[job.location] || job.location;
            }

            const jobListingHTML = `
                <div class="job-listing">
                    <h3 class="job-listing__title"><a href="${job.url}" target="window">${job.title}</a></h3>
                    <p class="job-listing__meta">${job.practice} <span class="divider">|</span> ${jobLocation}</p>
                </div>
            `;
            jobList.innerHTML += jobListingHTML;
        });
    }

    function filterJobs() {
        const location = locationFilter.value;
        const practice = practiceFilter.value;

        let filteredJobs = allJobs;

        if (location) {
            if (location === "Remote") {
                filteredJobs = filteredJobs.filter(job => job.location.includes("Remote"));
            } else {
                filteredJobs = filteredJobs.filter(job => job.location === location);
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

    // Check if jobs JSON is already stored in sessionStorage
    if (sessionStorage.getItem('jobsData')) {
        const jobsData = JSON.parse(sessionStorage.getItem('jobsData'));
        buildAllJobs(jobsData);
    } else {
        fetchJobs();
    }

    // Check if practices JSON is already stored in sessionStorage
    if (sessionStorage.getItem('practicesData')) {
        const practicesData = JSON.parse(sessionStorage.getItem('practicesData'));
        buildParentDepartmentsMap(practicesData);
        populatePractices(practicesData.departments);
    } else {
        fetchPractices();
    }
});
</script>