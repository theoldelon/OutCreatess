@extends('front.layouts.app')

@section('main')
<section class="section-5 py-5 bg-light">
    <div class="container my-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0 p-5 rounded-lg">
                    <h1 class="h3 mb-4 text-gray-900">Register</h1>
                    <form action="" method="POST" name="registrationForm" id="registrationForm">
                        @csrf <!-- Include this if you're using Laravel to handle CSRF protection -->
                        <div class="mb-4">
                            <label for="name" class="form-label text-gray-700">Name*</label>
                            <input type="text" name="name" id="name" class="form-control border-gray-300 rounded-md" placeholder="Enter Name" required>
                        </div> 
                        <div class="mb-4">
                            <label for="email" class="form-label text-gray-700">Email*</label>
                            <input type="text" name="email" id="email" class="form-control border-gray-300 rounded-md" placeholder="Enter Email" required>
                        </div> 
                        <div class="mb-4">
                            <label for="password" class="form-label text-gray-700">Password*</label>
                            <input type="password" name="password" id="password" class="form-control border-gray-300 rounded-md" placeholder="Enter Password" required>
                        </div> 
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label text-gray-700">Confirm Password*</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control border-gray-300 rounded-md" placeholder="Confirm Password" required>
                        </div> 
                        <button type="submit" class="btn bg-blue-600 text-gray-100 hover:bg-blue-700 rounded-md mt-4 w-full">Register</button>
                    </form>   
                    <div class="mt-4 text-center">
                        <p class="text-gray-600">Have an account? <a href="{{ route('account.login') }}" class="text-blue-500 font-semibold hover:underline">Login</a></p>
                    </div>                 
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
    <script>
        $("#registrationForm").submit(function(e){
            e.preventDefault();
            $.ajax({
                url: '{{ route("account.processRegistration") }}', // Corrected spelling of the route to "processRegistration"
                type: 'post',
                data: $("#registrationForm").serializeArray(),
                dataType: 'json',
                success: function(response) {
                    if(response.status === false) {
                        var errors = response.errors;

                        if(errors.name) {
                            $("#name").addClass('is-invalid') // Added the correct id selector for the name input
                            .siblings('.invalid-feedback')
                            .remove(); // Remove any existing error messages first

                            $("#name").after('<p class="invalid-feedback text-danger">' + errors.name + '</p>'); // Show error message
                        }

                        if(errors.email) {
                            $("#email").addClass('is-invalid')
                            .siblings('.invalid-feedback')
                            .remove();

                            $("#email").after('<p class="invalid-feedback text-danger">' + errors.email + '</p>');
                        }

                        if(errors.password) {
                            $("#password").addClass('is-invalid')
                            .siblings('.invalid-feedback')
                            .remove();

                            $("#password").after('<p class="invalid-feedback text-danger">' + errors.password + '</p>');
                        }

                        if(errors.password_confirmation) {
                            $("#password_confirmation").addClass('is-invalid')
                            .siblings('.invalid-feedback')
                            .remove();

                            $("#password_confirmation").after('<p class="invalid-feedback text-danger">' + errors.password_confirmation + '</p>');
                        }
                    } else {
                        // If the registration is successful, you can redirect or show a success message.
                        window.location.href = '{{ route("account.login") }}'; // Example redirect after successful registration
                    }
                },
                error: function(xhr) {
                    console.error("An error occurred:", xhr.responseText);
                }
            });
        });
    </script>
@endsection
