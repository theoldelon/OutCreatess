<!DOCTYPE html>
<html class="no-js" lang="en_AU" />
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>OutCreate | Find Best Jobs</title>
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
	<meta name="HandheldFriendly" content="True" />
	<meta name="pinterest" content="nopin" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<link rel="shortcut icon" type="image/x-icon" href="#" />
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Bootstrap JS and Popper.js -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

	<meta name="csrf-token" content="{{ csrf_token() }}">
	
</head>
<body data-instant-intensity="mousedown">
<header>
	<nav class="navbar navbar-expand-lg navbar-light bg-light shadow py-3">
		<div class="container">
			<a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
				<img src="{{ asset('assets/images/outcreate-logos.jpg') }}" alt="" class="logo-img" style="height: 50px; width: 55px; margin-right: 10px; border-radius: 50%;">
				<span class="fw-bold text-primary">OutCreate</span>
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link" href="#"><i class="fas fa-briefcase"></i> Find Jobs</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"><i class="fas fa-user-tie"></i> Find Clients</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="#"><i class="fas fa-info-circle"></i> How It Works</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fas fa-th-list"></i> Categories
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item" href="#">Web Development</a></li>
							<li><a class="dropdown-item" href="#">Design & Creative</a></li>
							<li><a class="dropdown-item" href="#">Marketing</a></li>
							<li><a class="dropdown-item" href="#">Customer Service</a></li>
						</ul>
					</li>
				</ul>
	
				<!-- Authentication Links -->
				<div class="d-flex">
					@guest
						<a class="btn btn-outline-primary me-2" href="{{ route('account.login') }}">Login</a>
						<a class="btn btn-primary" href="{{ route('account.registration') }}">Sign Up</a>
					@else
						<div class="d-flex align-items-center">
							<a class="btn btn-outline-primary me-2" href="{{ route('account.profile') }}"><i class="fas fa-user"></i>&nbsp;{{ Auth::user()->name }}</a>
							<a class="btn btn-outline-primary me-2" href="{{ route('account.createJob') }}"><i class="fas fa-plus-circle"></i> Post a Job</a>
							<a class="btn btn-outline-primary" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
								<i class="fas fa-sign-out-alt"></i> Logout
							</a>
							
						</div>
					@endguest
				</div>
			</div>
		</div>
	</nav>
	
</header>


@yield('main')

<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				Are you sure you want to log out?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<a class="btn btn-primary" href="{{ route('account.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
				<!-- Ensure form action points to the logout route -->
				<form id="logout-form" action="{{ route('account.logout') }}" method="POST" class="d-none">
					@csrf
				</form>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="profilePicForm" name="profilePicForm" action="" method="POST" enctype="multipart/form-data">
					@csrf <!-- Include CSRF token -->
					<div class="mb-3">
						<label for="image" class="form-label">Profile Image</label>
						<input type="file" class="form-control" id="image" name="image" required>
						<div id="emailHelp" class="form-text">Please select a valid image file.</div>
					</div>
					<div class="d-flex justify-content-end">
						<button type="submit" class="btn btn-primary mx-3">Update</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
</div>


<footer class="bg-gray-900 dark:bg-gray-900">
	<div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
		<div class="md:flex md:justify-between">
		  <div class="mb-6 md:mb-0">
			  <a href="https://flowbite.com/" class="flex items-center">
				  <img src="{{ asset('images/outcreate-logo.jpeg') }}" class="h-8 me-3 rounded-full" alt="FlowBite Logo" />
				  <span class="text-white self-center text-2xl font-semibold whitespace-nowrap dark:text-white mx-2">OutCreate</span>
			  </a>
		  </div>
		  <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
			  <div>
				  <h2 class="mb-6 text-sm font-semibold text-white uppercase dark:text-white">Resources</h2>
				  <ul class="text-gray-500 dark:text-gray-400 font-medium">
					  <li class="mb-4">
						  <a href="#" class="hover:underline">Flowbite</a>
					  </li>
					  <li>
						  <a href="#" class="hover:underline">Tailwind CSS</a>
					  </li>
				  </ul>
			  </div>
			  <div>
				  <h2 class="mb-6 text-sm font-semibold text-white uppercase dark:text-white">Follow us</h2>
				  <ul class="text-gray-500 dark:text-gray-400 font-medium">
					  <li class="mb-4">
						  <a href="https://github.com/themesberg/flowbite" class="hover:underline ">Github</a>
					  </li>
					  <li>
						  <a href="https://discord.gg/4eeurUVvTy" class="hover:underline">Discord</a>
					  </li>
				  </ul>
			  </div>
			  <div>
				  <h2 class="mb-6 text-sm font-semibold text-white uppercase dark:text-white">Legal</h2>
				  <ul class="text-gray-500 dark:text-gray-400 font-medium">
					  <li class="mb-4">
						  <a href="#" class="hover:underline">Privacy Policy</a>
					  </li>
					  <li>
						  <a href="#" class="hover:underline">Terms &amp; Conditions</a>
					  </li>
				  </ul>
			  </div>
		  </div>
	  </div>
	  <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
	  <div class="sm:flex sm:items-center sm:justify-between">
		  <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="#" class="hover:underline">OutCreate</a>. All Rights Reserved.
		  </span>
		  <div class="flex mt-4 sm:justify-center sm:mt-0">
			<a href="#" class="text-gray-500 hover:text-white dark:hover:text-white tracking-wider">
				<svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
					<path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
				</svg>
				<span class="sr-only">Facebook page</span>
			</a>
			<a href="#" class="text-gray-500 hover:text-white dark:hover:text-white mx-2 tracking-wider">
				<svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 21 16">
					<path d="M16.942 1.556a16.3 16.3 0 0 0-4.126-1.3 12.04 12.04 0 0 0-.529 1.1 15.175 15.175 0 0 0-4.573 0 11.585 11.585 0 0 0-.535-1.1 16.274 16.274 0 0 0-4.129 1.3A17.392 17.392 0 0 0 .182 13.218a15.785 15.785 0 0 0 4.963 2.521c.41-.564.773-1.16 1.084-1.785a10.63 10.63 0 0 1-1.706-.83c.143-.106.283-.217.418-.33a11.664 11.664 0 0 0 10.118 0c.137.113.277.224.418.33-.544.328-1.116.606-1.71.832a12.52 12.52 0 0 0 1.084 1.785 16.46 16.46 0 0 0 5.064-2.595 17.286 17.286 0 0 0-2.973-11.59ZM6.678 10.813a1.941 1.941 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.919 1.919 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Zm6.644 0a1.94 1.94 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.918 1.918 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Z"/>
				</svg>
				<span class="sr-only">Discord community</span>
			</a>
			<a href="#" class="text-gray-500 hover:text-white dark:hover:text-white mx-2 tracking-wider">
				<svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 17">
					<path fill-rule="evenodd" d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z" clip-rule="evenodd"/>
				</svg>
				<span class="sr-only">Twitter page</span>
			</a>
			<a href="#" class="text-gray-500 hover:text-white dark:hover:text-white mx-2 tracking-wider">
				<svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
					<path fill-rule="evenodd" d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z" clip-rule="evenodd"/>
				</svg>
				<span class="sr-only">GitHub account</span>
			</a>
			<a href="#" class="text-gray-500 hover:text-white dark:hover:text-white mx-2 tracking-wider">
				<svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
					<path fill-rule="evenodd" d="M10 0a10 10 0 1 0 10 10A10.009 10.009 0 0 0 10 0Zm6.613 4.614a8.523 8.523 0 0 1 1.93 5.32 20.094 20.094 0 0 0-5.949-.274c-.059.345-.144.696-.274 1.036-1.024 2.138-4.06 2.565-6.058 1.159a5.595 5.595 0 0 1-.939-.93c-1.17-1.18-.668-2.388 1.038-2.622 1.95-.254 3.781-.804 5.48-1.647.335-.161.62-.387.863-.657a3.786 3.786 0 0 0 1.342-.716Zm-2.354 8.46a.857.857 0 1 1-.855-.86.856.856 0 0 1 .855.86Z" clip-rule="evenodd"/>
				</svg>
				<span class="sr-only">YouTube channel</span>
			</a>
		</div>

	  </div>
	</div>
</footer>



<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

@yield('customJs')

<script>
    // Set up CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Handle form submission for updating the profile picture
    $('#profilePicForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission behavior

        // Clear previous error messages
        $('#imageError').text(''); // Assuming you have a span/div for displaying image error

        $.ajax({
            url: '{{ route("account.updateProfilePic") }}', // Replace with your update route
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                if (response.status == false) {
                    // Handle validation errors
                    var errors = response.errors;
                    if (errors.image) {
                        $('#imageError').text(errors.image[0]); // Display image validation error
                    }
                } else {
					window.location.href = '{{ url()->current() }}';
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX error response
                console.log('Error:', error);
                alert('An error occurred while updating the profile picture.');
            }
        });
    });
</script>

</body>
</html>