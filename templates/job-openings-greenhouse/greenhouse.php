
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
        try {
            const response = await fetch(JOBS_API_URL);
            const data = await response.json();
            
            await new Promise((resolve, reject) => {
                try {
                    sessionStorage.setItem('jobsData', JSON.stringify(data)); // Save jobs JSON to sessionStorage
                    resolve();
                } catch (error) {
                    reject(error);
                }
            });

            buildAllJobs(data);
        } catch (error) {
            console.error('Error fetching jobs:', error);
        }
    }

    async function fetchPractices() {
        try {
            const response = await fetch(PRACTICES_API_URL);
            let data = await response.json();
            data = removeDepartmentById(data, 4010536008); // Remove internal practice ID

            await new Promise((resolve, reject) => {
                try {
                    sessionStorage.setItem('practicesData', JSON.stringify(data)); // Save practices JSON to sessionStorage
                    resolve();
                } catch (error) {
                    reject(error);
                }
            });

            buildParentDepartmentsMap();
            populatePractices();
        } catch (error) {
            console.error('Error fetching practices:', error);
        }
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
        practicesData.departments.forEach(department => {
            parentDepartmentsMap[String(department.id)] = department.name; // Convert to string
        });
    }

    function removeDepartmentById(data, id) {
        data.departments = data.departments.filter(department => department.id !== id);
        return data;
    }

    function populatePractices() {
        const practicesData = JSON.parse(sessionStorage.getItem('practicesData'));

        practiceFilter.innerHTML = '<option value="">All Practices</option>'; // Reset options
        practicesData.departments.forEach(department => {
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
            let jobLocation = job.locations.map(location => {
                return officeLabels[location] || location;
            }).join('; ');

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
                filteredJobs = filteredJobs.filter(job => job.locations.some(loc => loc.toLowerCase().includes("remote")));
            } else {
                filteredJobs = filteredJobs.filter(job => job.locations.includes(location));
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
        populatePractices(practicesData);
    } else {
        fetchPractices();
    }
});

</script>