@extends('front.layouts.app')

@section('main')
<section class="section-3 py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-10">
                <h2 class="text-blue-600">Find Jobs</h2> <!-- Tailwind class for primary color -->
            </div>
            <div class="col-6 col-md-2">
                <div class="w-full flex justify-end"> <!-- Flexbox for alignment -->
                    <select name="sort" id="sort" class="w-full sm:w-auto border border-gray-300 rounded-lg p-2 shadow-sm focus:ring focus:ring-blue-200" onchange="redirectToSort()">
                        <option value="1" {{ (Request::get('sort') == '1' ? 'selected' : '') }}>Latest</option>
                        <option value="0" {{ (Request::get('sort') == '0' ? 'selected' : '') }}>Oldest</option>
                    </select>
                </div>
            </div>
        </div>
        

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <form action="" name="searchForm" id="searchForm">
                    <div class="card border-0 shadow-lg p-4 rounded-3 bg-white">
                        <!-- Keywords Section -->
                        <div class="mb-4">
                            <h2 class="h5 text-primary mb-2">Job Title</h2>
                            <input type="text" name="keyword" id="keyword" placeholder="Enter job title or keywords" class="form-control border-0 shadow-sm p-3 rounded-2" value="{{ Request::get('keyword') }}">
                        </div>

                        <!-- Location Section -->
                        <div class="mb-4">
                            <h2 class="h5 text-primary mb-2">Location</h2>
                            <input type="text" name="location" id="location" placeholder="City, State, or Zip Code" class="form-control border-0 shadow-sm p-3 rounded-2" value="{{ Request::get('location') }}">
                        </div>

                        <!-- Category Section -->
                        <div class="mb-4">
                            <h2 class="h5 text-primary mb-12">Category</h2>
                            <select name="category" id="category" class="w-full h-16 border border-gray-300 shadow-sm p-3 rounded-lg focus:ring focus:ring-blue-200">
                                <option value="">Select a Category</option>
                                @if ($categories)
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ Request::get('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        

                        <!-- Job Type Section -->
                        <div class="mb-4">
                            <h2 class="h5 text-primary mb-2">Job Type</h2>
                            <div class="d-flex flex-column">
                                @if ($jobTypes && $jobTypes->isNotEmpty())
                                    @foreach ($jobTypes as $jobType)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input shadow-sm" type="checkbox" id="jobTypeCheckbox{{ $jobType->id }}" value="{{ $jobType->id }}" name="jobTypes[]"
                                                {{ in_array($jobType->id, (array) Request::get('jobTypes', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jobTypeCheckbox{{ $jobType->id }}">{{ $jobType->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        

                        <!-- Experience Section -->
                        <div class="mb-4">
                            <h2 class="h5 text-primary mb-2">Experience</h2>
                            <select name="experience" id="experience" class="form-control border-0 shadow-sm rounded-2" style="height: 50px;">
                                <option value="">Select Experience</option>
                                <option value="1">1 Year</option>
                                <option value="2">2 Years</option>
                                <option value="3">3 Years</option>
                                <option value="4">4 Years</option>
                                <option value="5">5+ Years</option>
                            </select>
                            
                        </div>

                        <!-- Search Button -->
                        <div class="d-grid">
                            <button class="btn btn-primary shadow-sm py-3" type="submit">
                                <i class="fas fa-search me-2"></i> Search Jobs
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-8 col-lg-9">
                <div class="job_listing_area">
                    <div class="job_lists">
                        <div class="row">
                            @if ($jobs->isNotEmpty())
                                @foreach ($jobs as $job)
                                    <div class="col-md-12 mb-4">
                                        <div class="card border-0 p-3 shadow mb-4" style="min-height: 350px;">
                                            <div class="card-body">
                                                <h3 class="border-0 fs-5 pb-2 mb-0">{{ $job->title }}</h3>
                                                <p>{{ Str::words(strip_tags($job->description), 15, '...') }}</p>
                                                <div class="bg-light p-3 border">
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                        <span class="ps-1">{{ $job->location }}</span>
                                                    </p>
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-clock"></i></span>
                                                        <span class="ps-1">{{ $job->jobType->name }}</span>
                                                    </p>
                                                    <p>{{ $job->category->name }}</p>
                                                    @if (!is_null($job->salary))
                                                        <p class="mb-0">
                                                            <span class="fw-bolder"><i class="fa fa-dollar-sign"></i></span>
                                                            <span class="ps-1">{{ $job->salary }}</span>
                                                        </p>
                                                    @endif
                                                </div>

                                                <div class="d-grid mt-3">
                                                    <a href="{{ route('jobDetail', $job->id) }}" class="btn btn-primary btn-lg">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div>
                                        <span class="text-muted font-light">Showing {{ $jobs->firstItem() }} to {{ $jobs->lastItem() }} of {{ $jobs->total() }} jobs</span>
                                    </div>
                                    <div>
                                        {{ $jobs->links('pagination::bootstrap-4') }} <!-- Bootstrap pagination -->
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12 text-center text-danger">No jobs found</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
    // Redirect to sort on change
    function redirectToSort() {
        const sortValue = document.getElementById('sort').value;
        const currentUrl = window.location.href.split('?')[0]; // Get current URL without query params
        let url = `${currentUrl}?sort=${sortValue}`; // Base URL for the jobs route
        
        // Append existing form parameters
        url += generateQueryParams();
        window.location.href = url; // Navigate to the constructed URL
    }

    // Generate query parameters from the form
    function generateQueryParams() {
        const params = [];
        const keyword = document.getElementById("keyword").value;
        const location = document.getElementById("location").value;
        const category = document.getElementById("category").value;
        const experience = document.getElementById("experience").value;

        // Add parameters if they have values
        if (keyword) params.push(`keyword=${encodeURIComponent(keyword)}`);
        if (location) params.push(`location=${encodeURIComponent(location)}`);
        if (category) params.push(`category=${encodeURIComponent(category)}`);
        if (experience) params.push(`experience=${encodeURIComponent(experience)}`);

        // Handle the job types checkboxes
        const checkedJobTypes = Array.from(document.querySelectorAll("input[name='jobTypes[]']:checked"))
            .map(input => input.value);
        if (checkedJobTypes.length > 0) {
            params.push(`jobTypes[]=${encodeURIComponent(checkedJobTypes.join('&jobTypes[]='))}`);
        }

        return params.length > 0 ? '&' + params.join('&') : ''; // Join params and return
    }

    // Submit the form on search button click
    document.getElementById("searchForm").addEventListener("submit", function(e) {
        e.preventDefault(); // Prevent the default form submission
        const url = '{{ route("jobs") }}?' + generateQueryParams();
        window.location.href = url; // Redirect to the constructed URL
    });
</script>
@endsection
