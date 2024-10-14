@extends('front.layouts.app')

@section('main')

<section class="section-5 bg-2 py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>

            <div class="col-lg-9">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body p-4">
                        <h3 class="text-lg font-semibold mb-4">My Profile</h3>
                        <form action="" method="POST" id="userForm" name="userForm">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block mb-2 font-medium">Name*</label>
                                <input type="text" id="name" name="name" placeholder="Enter Name" class="form-control border rounded-lg shadow-sm" value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block mb-2 font-medium">Email*</label>
                                <input type="email" id="email" name="email" placeholder="Enter Email" class="form-control border rounded-lg shadow-sm" value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="mb-4">
                                <label for="designation" class="block mb-2 font-medium">Designation*</label>
                                <input type="text" id="designation" name="designation" placeholder="Designation" class="form-control border rounded-lg shadow-sm" value="{{ old('designation', $user->designation) }}">
                            </div>
                            <div class="mb-4">
                                <label for="mobile" class="block mb-2 font-medium">Mobile*</label>
                                <input type="text" id="mobile" name="mobile" placeholder="Mobile" class="form-control border rounded-lg shadow-sm" value="{{ old('mobile', $user->mobile) }}">
                            </div>
                            <div class="mb-4">
                                <label for="hourly_rate" class="block mb-2 font-medium">Hourly Rate*</label>
                                <input type="text" id="hourly_rate" name="hourly_rate" placeholder="Hourly Rate" class="form-control border rounded-lg shadow-sm" value="{{ old('hourly_rate', $user->hourly_rate) }}">
                            <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="availability" class="block mb-2 font-medium">Availability*</label>
                                <select id="availability" name="availability" class="form-control border rounded-lg shadow-sm">
                                    <option value="available" {{ old('availability', $user->availability) == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="unavailable" {{ old('availability', $user->availability) == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                                    <option value="busy" {{ old('availability', $user->availability) == 'busy' ? 'selected' : '' }}>Busy</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="bio" class="block mb-2 font-medium">Bio</label>
                                <textarea id="bio" name="bio" placeholder="Tell us about yourself" class="form-control border rounded-lg shadow-sm">{{ old('bio', $user->bio) }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="skills" class="block mb-2 font-medium">Skills</label>
                                <textarea id="skills" name="skills" placeholder="List your skills" class="form-control border rounded-lg shadow-sm">{{ old('skills', $user->skills) }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="website" class="block mb-2 font-medium">Website</label>
                                <input type="url" id="website" name="website" placeholder="https://example.com" class="form-control border rounded-lg shadow-sm" value="{{ old('website', $user->website) }}">
                            </div>
                            <button type="submit" class="btn btn-primary w-full rounded-lg shadow-sm hover:bg-blue-700 transition">Update</button>
                        </form>
                    </div>
                </div>
            
                <div class="card border-0 shadow mb-4">
                    <form action="" method="post" id="changePasswordForm" name="changePasswordForm">
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-1">Change Password</h3>
                            <div class="mb-4">
                                <label for="" class="mb-2">Old Password*</label>
                                <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">New Password*</label>
                                <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Confirm Password*</label>
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="form-control">
                                <p></p>
                            </div>                        
                        </div>
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
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
    $("#userForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("account.updateProfile") }}',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status === false) {
                    // Clear previous error messages
                    $(".form-control").removeClass('is-invalid').siblings('.invalid-feedback').remove();

                    var errors = response.errors;

                    // Handle validation errors
                    if (errors.name) {
                        $("#name").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.name + '</p>');
                    }
                    if (errors.email) {
                        $("#email").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.email + '</p>');
                    }
                    if (errors.designation) {
                        $("#designation").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.designation + '</p>');
                    }
                    if (errors.mobile) {
                        $("#mobile").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.mobile + '</p>');
                    }
                    if (errors.hourly_rate) {
                        $("#hourly_rate").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.hourly_rate + '</p>');
                    }
                    if (errors.availability) {
                        $("#availability").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.availability + '</p>');
                    }
                    if (errors.bio) {
                        $("#bio").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.bio + '</p>');
                    }
                    if (errors.skills) {
                        $("#skills").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.skills + '</p>');
                    }
                    if (errors.website) {
                        $("#website").addClass('is-invalid').after('<p class="invalid-feedback text-danger">' + errors.website + '</p>');
                    }
                } else {
                    // Show success message and reset the form
                    alert('Profile updated successfully!');
                    $('#userForm')[0].reset(); // Clear the form fields
                }
            },
            error: function(xhr) {
                console.error("An error occurred:", xhr.responseText);
            }
        });
    });

    $("#changePasswordForm").submit(function(e){
    e.preventDefault();

    $.ajax({
        url: '{{ route("account.updatePassword") }}',
        type: 'post',
        dataType: 'json',
        data: $("#changePasswordForm").serializeArray(),
        success: function(response) {

            if(response.status == true) {

                $("#name").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                $("#email").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                window.location.href="{{ route('account.profile') }}";

            } else {
                var errors = response.errors;

                if (errors.old_password) {
                    $("#old_password").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.old_password)
                } else {
                    $("#old_password").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }

                if (errors.new_password) {
                    $("#new_password").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.new_password)
                } else {
                    $("#new_password").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }

                if (errors.confirm_password) {
                    $("#confirm_password").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.confirm_password)
                } else {
                    $("#confirm_password").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }
            }

        }
    });
});
</script>
@endsection
