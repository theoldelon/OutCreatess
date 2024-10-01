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
    @if (session('success'))
    <div style="color: green; background-color: #e6ffed; padding: 10px; border-radius: 5px; width: 300px; margin: 10px auto; text-align: center;">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
        <div style="color: red; background-color: #ffe6e6; padding: 10px; border-radius: 5px; width: 300px; margin: 10px auto; text-align: center;">
            {{ session('error') }}
        </div>
    @endif

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
                                            <i class="fa fa-map-marker-alt"></i> {{ $job->location }}
                                        </div>
                                    @endif
                                    @if(!empty($job->jobType->name))
                                        <div>
                                            <i class="fa fa-clock"></i> {{ $job->jobType->name }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="jobs_right">
                                <a class="heart_mark" href="#">
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Job Details Content -->
                    <div class="descript_wrap p-4">
                        @if(!empty($job->description))
                            <div class="mb-4 bg-light p-3 rounded">
                                <h5 class="fw-bold">Job Description</h5>
                                <p>{!! nl2br(e($job->description)) !!}</p>
                            </div>
                        @endif
                    
                        @if(!empty($job->responsibility))
                            <div class="mb-4 bg-light p-3 rounded">
                                <h5 class="fw-bold">Responsibilities</h5>
                                <p>{!! nl2br(e($job->responsibility)) !!}</p>
                            </div>
                        @endif
                    
                        @if(!empty($job->qualifications))
                            <div class="mb-4 bg-light p-3 rounded">
                                <h5 class="fw-bold">Qualifications</h5>
                                <p>{!! nl2br(e($job->qualifications)) !!}</p>
                            </div>
                        @endif
                    
                        @if(!empty($job->benefits))
                            <div class="mb-4 bg-light p-3 rounded">
                                <h5 class="fw-bold">Benefits</h5>
                                <p>{!! nl2br(e($job->benefits)) !!}</p>
                            </div>
                        @endif
                    
                        <div class="border-top mt-4 pt-3 text-end">
                            <a href="#" class="btn btn-outline-secondary me-2">Save</a>
                            @if (Auth::check())
                            <a href="#" onclick="applyJob({{ $job->id }})" class="btn btn-primary">Apply Now</a>                  
                            @else
                            <a href="{{ route('account.login') }}" class="btn btn-primary">Login to apply</a>  
                            @endif
                        </div>
                    </div>
                    
                </div>
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

@section('customJs')
<script type="text/javascript">
function applyJob(id)
{
    if (confirm("Are you wan`t apply this job?"))
    {
        $.ajax({
            type: 'post',
            url: '{{ route("applyJob") }}',
            data: {id:id},
            dataType: 'json',
            success: function(response)
            {
               window.location.href="{{ url()->current() }}"
            }
        })
    }
}
</script>
@endsection
