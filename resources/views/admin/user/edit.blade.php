@extends('front.layouts.app')

@section('main')

<section class="section-5 bg-gray-100 py-10">
    <div class="container mx-auto">
        <div class="flex flex-wrap">
            <!-- Sidebar -->
            <div class="w-full lg:w-1/4 mb-8 lg:mb-0">
                @include('admin.sidebar')
            </div>

            <!-- Main Content -->
            <div class="w-full lg:w-3/4 pl-8">
                <form action="" method="POST" id="userForm" name="userForm" class="bg-white p-6 shadow-md rounded-lg">
                    @csrf

                    <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit User</h1>

                    <div class="mb-4">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Name*</label>
                        <input type="text" id="name" name="name" placeholder="Enter Name" class="border border-gray-300 rounded-lg shadow-sm w-full p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email*</label>
                        <input type="email" id="email" name="email" placeholder="Enter Email" class="border border-gray-300 rounded-lg shadow-sm w-full p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="designation" class="block mb-2 text-sm font-medium text-gray-700">Designation*</label>
                        <input type="text" id="designation" name="designation" placeholder="Designation" class="border border-gray-300 rounded-lg shadow-sm w-full p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ old('designation', $user->designation) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="mobile" class="block mb-2 text-sm font-medium text-gray-700">Mobile*</label>
                        <input type="text" id="mobile" name="mobile" placeholder="Mobile" class="border border-gray-300 rounded-lg shadow-sm w-full p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ old('mobile', $user->mobile) }}" required>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white w-full rounded-lg shadow-sm py-2 hover:bg-blue-700 transition">Update</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')

<script>
    $("#userForm").submit(function(e) {
        e.preventDefault();

        // Disable button to prevent multiple submissions
        $("#submitButton").prop("disabled", true).addClass("opacity-50 cursor-not-allowed");

        $.ajax({
            url: '{{ route("admin.users.update", $user->id) }}',
            type: 'PUT',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(response) {
                // Re-enable button after response
                $("#submitButton").prop("disabled", false).removeClass("opacity-50 cursor-not-allowed");

                if (response.status === false) {
                    $(".form-control").removeClass('is-invalid').siblings('.invalid-feedback').remove();

                    var errors = response.errors;

                    if (errors.name) {
                        $("#name").addClass('is-invalid').after('<p class="invalid-feedback text-red-600">' + errors.name + '</p>');
                    }
                    if (errors.email) {
                        $("#email").addClass('is-invalid').after('<p class="invalid-feedback text-red-600">' + errors.email + '</p>');
                    }
                    if (errors.designation) {
                        $("#designation").addClass('is-invalid').after('<p class="invalid-feedback text-red-600">' + errors.designation + '</p>');
                    }
                    if (errors.mobile) {
                        $("#mobile").addClass('is-invalid').after('<p class="invalid-feedback text-red-600">' + errors.mobile + '</p>');
                    }

                } else {
                    alert('Profile updated successfully!');
                    // Redirect to the admin page after successful update
                    window.location.href = '{{ route("admin.users") }}';
                }
            },
            error: function(xhr) {
                console.error("An error occurred:", xhr.responseText);
                // Re-enable button if an error occurs
                $("#submitButton").prop("disabled", false).removeClass("opacity-50 cursor-not-allowed");
            }
        });
    });
</script>

@endsection
