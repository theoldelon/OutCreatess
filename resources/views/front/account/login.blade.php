@extends('front.layouts.app')

@section('main')
<section class="section-5 py-5 bg-light">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        
        <!-- Display success message -->
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        
        <!-- Display error message for failed login -->
        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        
        <div class="row d-flex justify-content-center rounded-lg">
            <div class="col-md-5">
                <div class="card shadow-lg border-0 p-5 rounded-lg">
                    <h1 class="h3 mb-4 text-gray-900">Login</h1>
                    <form action="{{ route('account.authenticate') }}" method="POST">
                        @csrf <!-- Laravel CSRF protection -->
                        
                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label text-gray-700">Email*</label>
                            <input type="email" name="email" id="email" class="form-control border-gray-300 rounded-md" placeholder="example@example.com" required>
                            
                            <!-- Display email validation errors -->
                            @if ($errors->has('email'))
                                <span class="text-danger text-sm">{{ $errors->first('email') }}</span>
                            @endif
                        </div> 
                        
                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label text-gray-700">Password*</label>
                            <input type="password" name="password" id="password" class="form-control border-gray-300 rounded-md" placeholder="Enter Password" required>
                            
                            <!-- Display password validation errors -->
                            @if ($errors->has('password'))
                                <span class="invalid-feedback text-sm">{{ $errors->first('password') }}</span>
                            @endif
                        </div> 
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn bg-blue-600 text-gray-100 hover:bg-blue-700 rounded-md mt-4">Login</button>
                            <a href="" class="text-blue-500 font-semibold hover:underline mt-4">Forgot Password?</a>
                        </div>
                    </form>    
                    
                    <div class="mt-4 text-center">
                        <p class="text-gray-600">Don't have an account? <a href="{{ route('account.registration') }}" class="text-blue-500 font-semibold hover:underline">Register</a></p>
                    </div>                
                </div>
            </div>
        </div>
        <div class="py-lg-5">&nbsp;</div>
    </div>
</section>
@endsection
