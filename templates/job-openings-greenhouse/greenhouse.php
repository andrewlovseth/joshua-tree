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
    const OFFICES_API_URL = 'https://api.greenhouse.io/v1/boards/environmentalscienceassociates/offices?render_as=tree';

    let allJobs = [];
    let parentDepartmentsMap = {};

    async function fetchJobs() {
        const response = await fetch(JOBS_API_URL);
        const data = await response.json();
        allJobs = data.jobs.map((job) => {
            return {
                title: job.title,
                url: job.absolute_url,
                location: job.location.name,
                department_parent_id: job.departments[0] ? job.departments[0].parent_id : 'Unknown ID'
            };
        });

        displayJobs(allJobs);
    }

    async function fetchPractices() {
        const response = await fetch(PRACTICES_API_URL);
        const data = await response.json();
        const topLevelDepartments = data.departments.map((department) => {
            parentDepartmentsMap[department.id] = department.name;
            return {
                id: department.id,
                name: department.name,
            };
        });

        populatePractices(topLevelDepartments);
    }

    async function fetchOffices() {
        const response = await fetch(OFFICES_API_URL);
        const data = await response.json();
        populateOffices(data.offices);
    }

    function populatePractices(departments) {
        departments.forEach(department => {
            const option = document.createElement('option');
            option.value = department.name;
            option.textContent = department.name;
            practiceFilter.appendChild(option);
        });
    }

    function populateOffices(offices) {
        offices.forEach(office => {
            // Add first-level office
            let option = document.createElement('option');
            option.value = office.name;
            option.textContent = office.name;
            locationFilter.appendChild(option);

            // Add second-level offices (children)
            office.children.forEach(childOffice => {
                let childOption = document.createElement('option');
                childOption.value = childOffice.name;
                childOption.textContent = `- ${childOffice.name}`;
                locationFilter.appendChild(childOption);
            });
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
            const jobTitle = job.title;
            const jobLocation = job.location ? job.location : 'Unknown Location';
            const jobPractice = parentDepartmentsMap[job.department_parent_id] ? parentDepartmentsMap[job.department_parent_id] : 'Unknown Practice';
            const jobURL = job.url;
            const jobListingHTML = `
                <div class="job-listing">
                    <h3 class="job-listing__title"><a href="${jobURL}" target="window">${jobTitle}</a></h3>
                    <p class="job-listing__meta">${jobPractice} <span class="divider">|</span> ${jobLocation}</p>
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
            filteredJobs = filteredJobs.filter(job => job.location === location);
        }

        if (practice) {
            filteredJobs = filteredJobs.filter(job => parentDepartmentsMap[job.department_parent_id] === practice);
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

    fetchJobs();
    fetchPractices();
    fetchOffices();
});


</script>