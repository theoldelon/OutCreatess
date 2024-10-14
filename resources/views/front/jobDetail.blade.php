@extends('front.layouts.app')

@section('main')
<section class="section-4 bg-2">    
    <div class="container pt-5">
        <!-- Breadcrumb -->
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 bg-light shadow-sm">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('jobs') }}" class="text-decoration-none text-primary">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div id="message-container" class="{{ session('success') || session('error') ? '' : 'hidden' }} fixed top-4 left-1/2 transform -translate-x-1/2 z-50 transition duration-300 {{ session('success') ? 'bg-green-500' : 'bg-red-500' }} text-white p-4 rounded-md">
        <span id="message-text">
            {{ session('success') ?? session('error') }}
        </span>
    </div>
    
    <!-- Loading Spinner -->
    <div id="loading-spinner" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    
    <div class="container job_details_area mt-4">
        <div class="row pb-5">
            <!-- Job Details Section -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="job_details_header p-4">
                        <div class="single_jobs d-flex justify-content-between align-items-center">
                            <div class="jobs_content">
                                <h4 class="fw-bold">{{ $job->title }}</h4>
                                <div class="d-flex mt-2">
                                    @if(!empty($job->location))
                                        <div class="me-3">
                                            <i class="fa fa-map-marker-alt" aria-hidden="true" title="Location"></i> {{ $job->location }}
                                        </div>
                                    @endif
                                    @if(!empty($job->jobType->name))
                                        <div>
                                            <i class="fa fa-clock" aria-hidden="true" title="Job Type"></i> {{ $job->jobType->name }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="jobs_right">
                                <a class="heart_mark {{ ($count == 1) ? 'saved-job' : '' }}" href="javascript:void(0)" onclick="saveJob({{ $job->id }})" aria-label="Save Job">
                                    <i class="fa {{ ($count == 1) ? 'fa-heart' : 'fa-heart-o' }}" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
            
                    <!-- Job Details Content -->
                    <div class="descript_wrap p-4">
                        @if(!empty($job->description))
                            <div class="mb-4 bg-light p-3 rounded">
                                <h5 class="fw-bold">Job Description</h5>
                                <p>{!! nl2br(e(strip_tags($job->description))) !!}</p>
                            </div>
                        @endif
                        
                        @if(!empty($job->responsibility))
                            <div class="mb-4 bg-light p-3 rounded">
                                <h5 class="fw-bold">Responsibilities</h5>
                                <p>{!! nl2br(e(strip_tags($job->responsibility))) !!}</p>
                            </div>
                        @endif
                        
                        @if(!empty($job->qualifications))
                            <div class="mb-4 bg-light p-3 rounded">
                                <h5 class="fw-bold">Qualifications</h5>
                                <p>{!! nl2br(e(strip_tags($job->qualifications))) !!}</p>
                            </div>
                        @endif
                        
                        @if(!empty($job->benefits))
                            <div class="mb-4 bg-light p-3 rounded">
                                <h5 class="fw-bold">Benefits</h5>
                                <p>{!! nl2br(e(strip_tags($job->benefits))) !!}</p>
                            </div>
                        @endif
                        
                        <div class="border-top mt-4 pt-3 text-end">
                            @if (Auth::check())
                                <a href="#" onclick="saveJob({{ $job->id }});" class="btn btn-outline-secondary me-2 hover:bg-gray-200 transition">Save</a> 
                            @endif
            
                            @if (Auth::check())
                                <a href="#" onclick="applyJob({{ $job->id }})" class="btn btn-primary hover:bg-blue-600 transition">Apply Now</a>                  
                            @else
                                <a href="{{ route('account.login') }}" class="btn btn-primary hover:bg-blue-600 transition">Login to apply</a>  
                            @endif
                        </div>
                    </div>    
                </div>
            
                @if (Auth::user() && Auth::user()->id == $job->user_id)
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden w-full mt-4">
                        <div class="p-6">
                            <!-- Applicants Header -->
                            <h4 class="text-xl font-bold text-gray-800 mb-4">Applicants</h4>
                    
                            <!-- Applicants Table -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto bg-white rounded-md">
                                    <thead>
                                        <tr class="text-left text-sm font-semibold text-gray-600 border-b border-gray-200">
                                            <th class="py-3 px-4">Name</th>
                                            <th class="py-3 px-4">Email</th>
                                            <th class="py-3 px-4">Phone</th>
                                            <th class="py-3 px-4">Applied Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700">
                                        @if ($applications->isNotEmpty())
                                            @foreach ($applications as $application)
                                                <tr class="border-b hover:bg-gray-100 transition">
                                                    <td class="py-3 px-4">
                                                        <div class="sm:hidden font-semibold text-gray-600">Name:</div>
                                                        {{ $application->user->name }}
                                                    </td>
                                                    
                                                    <td class="py-3 px-4">
                                                        <div class="sm:hidden font-semibold text-gray-600">Email:</div>
                                                        {{ $application->user->email }}
                                                    </td>
                                                    
                                                    <td class="py-3 px-4">
                                                        <div class="sm:hidden font-semibold text-gray-600">Phone:</div>
                                                        {{ $application->user->mobile }}
                                                    </td>
                                                    
                                                    <td class="py-3 px-4">
                                                        <div class="sm:hidden font-semibold text-gray-600">Applied Date:</div>
                                                        {{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="py-6 text-center text-gray-500">No applicants found.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Job Summary and Company Info Section -->
            <div class="col-md-4">
                <!-- Job Summary -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="p-4">
                        <h5 class="fw-bold">Job Summary</h5>
                        <ul class="list-unstyled mt-3">
                            @if(!empty($job->created_at))
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fa fa-calendar-check me-2" aria-hidden="true"></i>
                                    <strong>Published on:</strong> <span>&nbsp;{{ $job->created_at->format('d M, Y') }}</span>
                                </li>
                            @endif

                            @if(!empty($job->vacancy))
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fa fa-users me-2" aria-hidden="true"></i>
                                    <strong>Vacancy:</strong> <span>&nbsp;{{ $job->vacancy }}</span>
                                </li>
                            @endif

                            @if(!empty($job->salary))
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fa fa-dollar-sign me-2" aria-hidden="true"></i>
                                    <strong>Salary:</strong> <span>&nbsp;{{ $job->salary }}</span>
                                </li>
                            @endif

                            @if(!empty($job->location))
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fa fa-map-marker-alt me-2" aria-hidden="true"></i>
                                    <strong>Location:</strong> <span>&nbsp;{{ $job->location }}</span>
                                </li>
                            @endif

                            @if(!empty($job->jobType->name))
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fa fa-briefcase me-2" aria-hidden="true"></i>
                                    <strong>Job Type:</strong> <span>&nbsp;{{ $job->jobType->name }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Company Details -->
                <div class="card shadow-sm border-0">
                    <div class="p-4">
                        <h5 class="fw-bold">Company Details</h5>
                        <ul class="list-unstyled mt-3">
                            @if(!empty($job->company_name))
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fa fa-building me-2" aria-hidden="true"></i>
                                    <strong>Name:</strong> <span>&nbsp;{{ $job->company_name }}</span>
                                </li>
                            @endif
                            @if(!empty($job->company_location))
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fa fa-map-marker-alt me-2" aria-hidden="true"></i>
                                    <strong>Location:</strong> <span>&nbsp;{{ $job->company_location }}</span>
                                </li>
                            @endif
                            @if(!empty($job->company_website))
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fa fa-globe me-2" aria-hidden="true"></i>
                                    <strong>Website:</strong> 
                                    <a href="{{ $job->company_website }}" target="_blank" class="text-decoration-none text-primary">
                                        &nbsp;{{ $job->company_website }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>
@endsection
@section('content')
    <div id="message-container" class="{{ session('success') || session('error') ? '' : 'hidden' }} fixed top-4 left-1/2 transform -translate-x-1/2 z-50 transition duration-300 {{ session('success') ? 'bg-green-500' : 'bg-red-500' }} text-white p-4 rounded-md">
        <span id="message-text">
            {{ session('success') ?? session('error') }}
        </span>
    </div>

    <!-- Your other HTML content goes here -->

    @section('customJs')
    <script type="text/javascript">
        const messageDuration = 3000; // Duration in milliseconds (3 seconds)

        function showMessage(message, isError = false) {
            const messageContainer = document.getElementById('message-container');
            const messageText = document.getElementById('message-text');

            // Set the message text and styling
            messageText.innerText = message;
            messageContainer.className = `fixed top-4 left-1/2 transform -translate-x-1/2 p-4 rounded-md z-50 transition duration-300 ${isError ? 'bg-red-500' : 'bg-green-500'} text-white`;
            
            // Show the message
            messageContainer.classList.remove('hidden');

            // Hide the message after the specified duration
            setTimeout(() => {
                messageContainer.classList.add('hidden');
            }, messageDuration);
        }

        function applyJob(id) {
            if (confirm("Are you sure you want to apply for this job?")) {
                // Show loading spinner
                document.getElementById('loading-spinner').style.display = 'block';

                $.ajax({
                    url: '{{ route("applyJob") }}',
                    type: 'POST',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    dataType: 'json',
                    success: function(response) {
                        document.getElementById('loading-spinner').style.display = 'none'; // Hide spinner
                        showMessage(response.message, !response.status); // Show success or error message
                        if (response.status) {
                            // Optionally, reload the page after a delay
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000); // Adjust the delay as needed
                        }
                    },
                    error: function(xhr) {
                        document.getElementById('loading-spinner').style.display = 'none'; // Hide spinner
                        showMessage('An error occurred: ' + (xhr.responseJSON?.message || 'Please try again.'), true); // Show error message
                    }
                });
            }
        }

        function saveJob(id) {
            // Show loading spinner (optional)
            document.getElementById('loading-spinner').style.display = 'block';

            $.ajax({
                url: '{{ route("saveJob") }}', // Corrected URL
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                dataType: 'json',
                success: function(response) {
                    document.getElementById('loading-spinner').style.display = 'none'; // Hide spinner
                    showMessage(response.message, !response.status); // Show success or error message
                    if (response.status) {
                        // Optionally, reload the page after a delay
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000); // Adjust the delay as needed
                    }
                },
                error: function(xhr) {
                    document.getElementById('loading-spinner').style.display = 'none'; // Hide spinner
                    showMessage('An error occurred: ' + (xhr.responseJSON?.message || 'Please try again.'), true); // Show error message
                }
            });
        }
        function removeJob(id)
{
    if(confirm("Sure want to remove?"))
    {
        $.ajax({
            type: "POST",
            url: "{{ route('account.removeSavedJobs') }}",
            data: {id: id},
            dataType: 'json',
            success: function(response)
            {
                window.location.href='{{ route("account.savedJobs") }}';
            }
        
        });
    }
}
    </script>
    @endsection
@endsection
