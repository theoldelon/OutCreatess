@extends('front.layouts.app')

@section('main')

<section class="section-5 bg-2 py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="card-body card-form p-4">
                    <h3 class="fs-4 mb-1">Edit Job Details</h3>
                    <form action="" method="POST" id="editJobForm" name="editJobForm">
                        @csrf <!-- Include CSRF token -->
                        
                        <!-- Job Details -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="title" class="mb-2">Title<span class="req">*</span></label>
                                <input value="{{ $job->title }}" type="text" placeholder="Job Title" id="title" name="title" class="form-control" required>
                                <p></p>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="category" class="mb-2">Category<span class="req">*</span></label>
                                <select name="category_id" id="category" class="form-control" required>
                                    <option value="">Select a Category</option>
                                    @if ($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                    <option {{ ($job->category_id == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="job_nature" class="mb-2">Job Nature<span class="req">*</span></label>
                                <select name="job_type_id" id="job_nature" class="form-control" required>
                                    @if ($jobTypes->isNotEmpty())
                                    @foreach ($jobTypes as $jobType)
                                    <option {{ ($job->job_type_id == $jobType->id) ? 'selected' : '' }} value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                    @endforeach      
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="vacancy" class="mb-2">Vacancy<span class="req">*</span></label>
                                <input value="{{ $job->vacancy }}" type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control" required>
                                <p></p>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="salary" class="mb-2">Salary</label>
                                <input value="{{ $job->salary }}" type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                                <p></p>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="location" class="mb-2">Location<span class="req">*</span></label>
                                <input value="{{ $job->location }}" type="text" placeholder="Location" id="location" name="location" class="form-control" required>
                                <p></p>
                            </div>
                        </div>
                    
                        <div class="mb-4">
                            <label for="description" class="mb-2">Description<span class="req">*</span></label>
                            <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description" required>{{ $job->description }}</textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="benefits" class="mb-2">Benefits</label>
                            <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{ $job->benefits}}</textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="responsibility" class="mb-2">Responsibility</label>
                            <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">{{ $job->responsibility }}</textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="qualifications" class="mb-2">Qualifications</label>
                            <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">{{ $job->qualifications}}</textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="keywords" class="mb-2">Keywords<span class="req">*</span>{{ $job->keywords}}</label>
                            <input value="{{$job->keywords}}" type="text" placeholder="Keywords" id="keywords" name="keywords" class="form-control" required>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="experience" class="mb-2">Years of Experience</label>
                            <select class="form-control" name="experience" id="experience">
                                <option value="" disabled selected>Select years of experience</option>
                                <option value="0"{{ ($job->experience == 0) ? 'selected' : '' }} >0 years (No experience)</option>
                                <option value="1"{{ ($job->experience == 1) ? 'selected' : '' }} >1 year</option>
                                <option value="2"{{ ($job->experience == 2) ? 'selected' : '' }}>2 years</option>
                                <option value="3"{{ ($job->experience == 3) ? 'selected' : '' }}>3 years</option>
                                <option value="4"{{ ($job->experience == 4) ? 'selected' : '' }}>4 years</option>
                                <option value="5"{{ ($job->experience == 5) ? '5_plus' : '' }}>5+ years</option>
                            </select>
                            <p></p>
                        </div>
                    
                        <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>
                    
                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label for="company_name" class="mb-2">Name<span class="req">*</span></label>
                                <input value="{{ $job->company_name }}" type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control" required>
                                <p></p>
                            </div>
                            <div class="mb-4 col-md-6">
                                <label for="company_location" class="mb-2">Location</label>
                                <input value="{{ $job->company_location }}" type="text" placeholder="Location" id="company_location" name="company_location" class="form-control">
                                <p></p>
                            </div>
                        </div>
                    
                        <div class="mb-4">
                            <label for="website" class="mb-2">Website</label>
                            <input value="{{ $job->company_website }}" type="text" placeholder="Website" id="website" name="company_website" class="form-control">
                            <p></p>
                        </div>
                    
                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary">Update Job</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')
<script type="text/javascript">
    // Include the CSRF token in AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Submit form with AJAX
    $("#editJobForm").submit(function(e) {
        e.preventDefault();
        console.log($(this).serializeArray());
        $("button[type='submit']").prop('disabled', true);
        $.ajax({
            url: '{{ route("account.updateJob" ,$job->id) }}',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(response) {
                $("button[type='submit']").prop('disabled', false);
                // Clear all previous error classes and messages
                $(".form-control").removeClass('is-invalid').siblings('.invalid-feedback').remove();

                if (response.status === false) {
                    var errors = response.errors;

                    // Loop through the errors and display error messages dynamically
                    $.each(errors, function(key, message) {
                        var field = $("#" + key);
                        field.addClass('is-invalid'); // Add the invalid class
                        
                        // Display error message under the field
                        if (field.next('.invalid-feedback').length === 0) { 
                            field.after('<p class="invalid-feedback text-danger">' + message + '</p>');
                        }
                    });
                } else {
                    // Redirect to myJobs page upon successful submission
                    window.location.href = '{{ route("account.myJobs") }}';
                }
            },
            error: function(xhr) {
                console.error("An error occurred:", xhr.responseText);
                alert('An unexpected error occurred. Please try again.');
            }
        });
    });
</script>
@endsection
