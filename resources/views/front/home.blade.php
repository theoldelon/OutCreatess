@extends('front.layouts.app')

@section('main')

<section class="section-0 relative d-flex bg-image-style dark overflow-hidden h-screen">
    @if (session('error'))
    <div class="alert alert-danger" id="error-message">
        {{ session('error') }}
    </div>
@endif

    <div class="video-background absolute inset-0 z-0">
        <video autoplay muted loop class="w-full h-full object-cover">
            <source src="assets/images/videoCall.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="video-overlay absolute inset-0 bg-black opacity-50 z-10"></div>
    <div class="container flex items-center justify-center h-full relative z-20">
        <div class="text-center">
            <h1 class="text-white text-4xl md:text-5xl font-bold leading-tight">Find Your Dream Job</h1>
            <p class="text-white text-lg md:text-xl mt-2">Thousands of jobs available.</p>
            <div class="banner-btn mt-5">
                <a href="#" class="btn btn-primary mb-4 mb-sm-0">Explore Now</a>
            </div>
        </div>
    </div>
</section>


<section class="section-1 py-5 "> 
    <div class="container">
        <div class="card border-0 shadow p-5">
            <form action="{{ route('jobs') }}" method="GET">
            <div class="row">
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <input type="text" class="form-control" name="keywords" id="keywords" placeholder="Keywords">
                </div>
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <input type="text" class="form-control" name="location" id="location" placeholder="Location">
                </div>
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <select name="category" id="category" class="form-control">
                        <option value="">Select a Category</option>
                        @if ($newCategories->isNotEmpty())
                        @foreach ($newCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach     
                        @endif
                    </select>
                </div>
                <div class="col-md-3 mb-xs-3 mb-sm-3 mb-lg-0">
                    <div class="d-grid gap-2">
                       {{-- <a href="jobs.html" class="btn btn-primary btn-block">Search</a>--}}
                       <button type="submit" class="btn btn-primary btn-block">Search</button>
                    </div>
                </div>
            </div> 
            </form>           
        </div>
    </div>
</section>

<section class="section-2 bg-2 py-5">
    <div class="container">
        <h2 class="text-center text-3xl font-bold mb-6">Popular Categories</h2>
        <div class="row flex flex-wrap justify-center">
            @if ($categories->isNotEmpty())
                @foreach ($categories as $category)
                    <div class="col-lg-4 col-xl-3 col-md-6 mb-4">
                        <div class="single_catagory p-6 bg-white shadow-lg rounded-lg flex flex-col items-center text-center">
                            <a href="{{ route('jobs').'?category='. $category->id }}" class="text-xl font-semibold pb-2 hover:text-blue-600">
                                <h4>{{ $category->name }}</h4>
                            </a>
                            <p class="mb-0 text-gray-500">
                                <span class="font-bold text-blue-600">0</span> Available positions
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<section class="section-3 py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Featured Jobs</h2>
        <div class="row">
            <div class="job_listing_area">                    
                <div class="job_lists">
                    <div class="row">
                        @if ($featuredJobs->isNotEmpty())
                            @foreach ($featuredJobs as $featuredJob)
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card border-0 p-3 shadow h-100">
                                    <div class="card-body">
                                        <h3 class="fs-5 pb-2 mb-0">
                                            <a href="{{ route('jobDetail', $featuredJob->id) }}" class="text-decoration-none text-dark">
                                                {{ $featuredJob->title }}
                                            </a>
                                        </h3>
                                        <p class="text-muted">{{ Str::words($featuredJob->description, 9, '...') }}</p>
                                        
                                        <div class="bg-light p-3 border rounded mt-2">
                                            <p class="mb-1" aria-label="Location">
                                                <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                <span class="ps-1">{{ $featuredJob->location }}</span>
                                            </p>
                                            <p class="mb-1" aria-label="Job Type">
                                                <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                <span class="ps-1">{{ $featuredJob->jobType->name }}</span>
                                            </p>
                                            @if (!is_null($featuredJob->salary))
                                            <p class="mb-0" aria-label="Salary">
                                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                <span class="ps-1">{{ $featuredJob->salary }}</span>
                                            </p>
                                            @endif
                                        </div>

                                        <div class="d-grid mt-3">
                                            <a href="{{ route('jobDetail', $featuredJob->id) }}" class="btn btn-primary btn-lg shadow-sm">Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="card p-4 text-center border-0 bg-warning">
                                    <p class="mb-0">Currently, there are no featured jobs available. Check back soon!</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="section-3 bg-2 py-5">
    <div class="container">
        <h2 class="text-center mb-5">Latest Jobs</h2>
        <div class="row">
            <div class="job_listing_area">                    
                <div class="job_lists">
                    <div class="row">
                        @if ($latestJobs->isNotEmpty())
                            @foreach ($latestJobs as $latestJob)
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="card border-0 p-3 shadow h-100">
                                    <div class="card-body">
                                        <h3 class="fs-5 pb-2 mb-0">
                                            <a href="{{ route('jobDetail', $latestJob->id) }}" class="text-decoration-none text-dark">
                                                {{ $latestJob->title }}
                                            </a>
                                        </h3>
                                        <p class="text-muted">{{ Str::words(strip_tags($latestJob->description), 9, '...') }}</p>
                                        <div class="bg-light p-3 border rounded">
                                            <p class="mb-1" aria-label="Location">
                                                <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                <span class="ps-1">{{ $latestJob->location }}</span>
                                            </p>
                                            <p class="mb-1" aria-label="Job Type">
                                                <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                <span class="ps-1">{{ $latestJob->jobType->name }}</span>
                                            </p>
                                            @if (!is_null($latestJob->salary))
                                            <p class="mb-0" aria-label="Salary">
                                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                <span class="ps-1">{{ $latestJob->salary }}</span>
                                            </p>
                                            @endif
                                        </div>

                                        <div class="d-grid mt-3">
                                            <a href="{{ route('jobDetail', $latestJob->id) }}" class="btn btn-primary btn-lg shadow-sm">Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="card p-4 text-center border-0 bg-warning">
                                    <p class="mb-0">No latest jobs available at this time. Please check back later!</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
