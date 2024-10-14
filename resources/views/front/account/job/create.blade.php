@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')

                <form action="" method="post" id="createJobForm" name="createJobForm">
                    @csrf <!-- CSRF Token -->
                    <div class="card border-0 shadow mb-4">
                        <div class="card-body card-form p-4">
                        <!-- Job Details -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="title" class="mb-2">Title<span class="req">*</span></label>
                                <input type="text" placeholder="Job Title" id="title" name="title" class="form-control" required>
                                <p></p>
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
                                <p></p>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="job_nature" class="mb-2">Job Nature<span class="req">*</span></label>
                                <select name="job_type_id" id="job_nature" class="form-control" required>
                                    @if ($jobTypes->isNotEmpty())
                                        @foreach ($jobTypes as $jobType)
                                            <option {{ isset($job) && $job->job_type_id == $jobType->id ? 'selected' : '' }} value="{{ $jobType->id }}">
                                                {{ $jobType->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label for="vacancy" class="mb-2">Vacancy<span class="req">*</span></label>
                                <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control" required>
                                <p></p>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="salary" class="mb-2">Salary</label>
                                <input type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                                <p></p>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="location" class="mb-2">Location<span class="req">*</span></label>
                                <input type="text" placeholder="Location" id="location" name="location" class="form-control" required>
                                <p></p>
                            </div>
                        </div>
                            <div class="mb-4">
                                <label for="description" class="mb-2">Description<span class="req">*</span></label>
                                <textarea class="textarea" name="description" id="description" cols="5" rows="5" placeholder="Description">{{ old('description') }}</textarea>
                                <p></p>
                            </div>

                            <div class="mb-4">
                                <label for="benefits" class="mb-2">Benefits</label>
                                <textarea class="textarea" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{ old('benefits') }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="responsibility" class="mb-2">Responsibility</label>
                                <textarea class="textarea" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">{{ old('responsibility') }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="qualifications" class="mb-2">Qualifications</label>
                                <textarea class="textarea" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">{{ old('qualifications') }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="experience" class="mb-2">Experience <span class="req">*</span></label>
                                <select name="experience" id="experience" class="form-control">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('experience') == $i ? 'selected' : '' }}>{{ $i }} Year{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                    <option value="10_plus" {{ old('experience') == '10_plus' ? 'selected' : '' }}>10+ Years</option>
                                </select>
                                <p></p>
                            </div>

                            <div class="mb-4">
                                <label for="keywords" class="mb-2">Keywords</label>
                                <input type="text" placeholder="Keywords" id="keywords" name="keywords" class="form-control" value="{{ old('keywords') }}">
                            </div>

                            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="company_name" class="mb-2">Name<span class="req">*</span></label>
                                    <input type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control" value="{{ old('company_name') }}">
                                    <p></p>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="company_location" class="mb-2">Location</label>
                                    <input type="text" placeholder="Location" id="company_location" name="company_location" class="form-control" value="{{ old('company_location') }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="website" class="mb-2">Website</label>
                                <input type="text" placeholder="Website" id="website" name="website" class="form-control" value="{{ old('website') }}">
                            </div>
                        </div> 
                        <div class="card-footer p-4">
                            <button type="submit" class="btn btn-primary">Save Job</button>
                        </div>               
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script type="text/javascript">
$(document).ready(function() {
    $("#createJobForm").submit(function(e) {
        e.preventDefault();
        $("button[type='submit']").prop('disabled', true);

        $.ajax({
            url: '{{ route("account.saveJob") }}',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(response) {
                $("button[type='submit']").prop('disabled', false);

                if (response.status) {
                    // Clear any previous error classes and messages
                    $(".form-control, .textarea").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    window.location.href = "{{ route('account.myJobs') }}";
                } else {
                    // Handle validation errors
                    $.each(response.errors, function(key, error) {
                        $("#" + key).addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(error);
                    });
                }
            },
            error: function(xhr) {
                $("button[type='submit']").prop('disabled', false);
                // Handle generic AJAX error
                alert('An error occurred. Please try again.');
            }
        });
    });
});
</script>
@endsection
