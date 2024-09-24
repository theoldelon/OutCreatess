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
                    <h3 class="fs-4 mb-1">Job Details</h3>
                    <form action="" method="POST" id="createJobForm" name="createJobForm">
                        <!-- Job Details -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="title" class="mb-2">Title<span class="req">*</span></label>
                                <input type="text" placeholder="Job Title" id="title" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="category" class="mb-2">Category<span class="req">*</span></label>
                                <select name="category_id" id="category" class="form-control" required>
                                    <option value="">Select a Category</option>
                                    @if ($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="job_nature" class="mb-2">Job Nature<span class="req">*</span></label>
                                <select name="job_type_id" id="job_nature" class="form-control" required>
                                    @if ($jobTypes->isNotEmpty())
                                    @foreach ($jobTypes as $jobType)
                                    <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                    @endforeach      
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="vacancy" class="mb-2">Vacancy<span class="req">*</span></label>
                                <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control" required>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="salary" class="mb-2">Salary</label>
                                <input type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="location" class="mb-2">Location<span class="req">*</span></label>
                                <input type="text" placeholder="Location" id="location" name="location" class="form-control" required>
                            </div>
                        </div>
                    
                        <div class="mb-4">
                            <label for="description" class="mb-2">Description<span class="req">*</span></label>
                            <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="benefits" class="mb-2">Benefits</label>
                            <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="responsibility" class="mb-2">Responsibility</label>
                            <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="qualifications" class="mb-2">Qualifications</label>
                            <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="keywords" class="mb-2">Keywords<span class="req">*</span></label>
                            <input type="text" placeholder="Keywords" id="keywords" name="keywords" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label for="experience" class="mb-2">Years of Experience</label>
                            <select class="form-control" name="experience" id="experience">
                                <option value="" disabled selected>Select years of experience</option>
                                <option value="0">0 years (No experience)</option>
                                <option value="1">1 year</option>
                                <option value="2">2 years</option>
                                <option value="3">3 years</option>
                                <option value="4">4 years</option>
                                <option value="5">5+ years</option>
                            </select>
                        </div>
                    
                        <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>
                    
                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label for="company_name" class="mb-2">Name<span class="req">*</span></label>
                                <input type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control" required>
                            </div>
                            <div class="mb-4 col-md-6">
                                <label for="company_location" class="mb-2">Location</label>
                                <input type="text" placeholder="Location" id="company_location" name="company_location" class="form-control">
                            </div>
                        </div>
                    
                        <div class="mb-4">
                            <label for="website" class="mb-2">Website</label>
                            <input type="text" placeholder="Website" id="website" name="company_website" class="form-control">
                        </div>
                    
                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary">Submit Job</button>
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
    $("#createJobForm").submit(function(e) {
        e.preventDefault();

        // Log the serialized form data for debugging
        console.log($(this).serializeArray());

        $.ajax({
            url: '{{ route("account.saveJob") }}', // Ensure this route exists in web.php
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(response) {
                // Clear previous error messages
                $(".form-control").removeClass('is-invalid').siblings('.invalid-feedback').remove();

                if (response.status === false) {
                    var errors = response.errors;

                    // Handle validation errors
                    if (errors.title) {
                        $("#title").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.title + '</p>');
                    }
                    if (errors.category_id) {
                        $("#category").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.category_id + '</p>');
                    }
                    if (errors.job_type_id) {
                        $("#job_nature").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.job_type_id + '</p>');
                    }
                    if (errors.vacancy) {
                        $("#vacancy").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.vacancy + '</p>');
                    }
                    if (errors.location) {
                        $("#location").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.location + '</p>');
                    }
                    if (errors.description) {
                        $("#description").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.description + '</p>');
                    }
                    if (errors.keywords) {
                        $("#keywords").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.keywords + '</p>');
                    }
                    if (errors.company_name) {
                        $("#company_name").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.company_name + '</p>');
                    }
                    // Handle other fields as necessary
                } else {
                    // Show success message
                    window.location.href = '{{ route("account.myJobs") }}'; 
                }
            },
            error: function(xhr) {
                console.error("An error occurred:", xhr.responseText);
                
                // Handle generic error
                alert('An unexpected error occurred. Please try again.');
            }
        });
    });
</script>

@endsection
