@extends('front.layouts.app')

@section('main')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Page Title -->
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-12">How It Works</h1>
    
    <!-- Steps Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <!-- Step 1: Sign Up -->
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <span class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-blue-600 text-white text-2xl font-bold">1</span>
            </div>
            <h2 class="text-xl font-semibold mb-2">Sign Up</h2>
            <p class="text-gray-600 mb-4">Create an account with just a few clicks. You can sign up using email, Google, or Facebook.</p>
            <p class="text-gray-600">Access all our services once registered.</p>
        </div>

        <!-- Step 2: Set Up Your Profile -->
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <span class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-blue-600 text-white text-2xl font-bold">2</span>
            </div>
            <h2 class="text-xl font-semibold mb-2">Set Up Your Profile</h2>
            <p class="text-gray-600 mb-4">Fill in your preferences, location, and interests to personalize your experience.</p>
            <p class="text-gray-600">This helps us match you with relevant services.</p>
        </div>

        <!-- Step 3: Start Using Our Service -->
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <span class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-blue-600 text-white text-2xl font-bold">3</span>
            </div>
            <h2 class="text-xl font-semibold mb-2">Start Using Our Service</h2>
            <p class="text-gray-600 mb-4">Browse through our extensive range of services and choose what fits your needs best.</p>
            <p class="text-gray-600">Engage with providers, manage bookings, and track progress on your dashboard.</p>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gray-100 py-12 px-6 rounded-lg mb-12">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Why Choose Us?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <h3 class="text-xl font-semibold mb-2">Wide Range of Services</h3>
                <p class="text-gray-600">We offer a diverse selection of services to meet all your needs, from home care to personal services.</p>
            </div>
            <div class="text-center">
                <h3 class="text-xl font-semibold mb-2">Verified Providers</h3>
                <p class="text-gray-600">Our providers are thoroughly vetted to ensure top-quality service and security for our users.</p>
            </div>
            <div class="text-center">
                <h3 class="text-xl font-semibold mb-2">Secure Payments</h3>
                <p class="text-gray-600">We use encrypted payment systems for all transactions, ensuring your security and peace of mind.</p>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Frequently Asked Questions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-lg font-semibold mb-2">How do I sign up?</h3>
                <p class="text-gray-600">Click the "Get Started" button and complete the sign-up process. You can use your email or a social media account.</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Is my information secure?</h3>
                <p class="text-gray-600">Absolutely. We use state-of-the-art encryption technology to keep your information secure.</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Can I cancel a booking?</h3>
                <p class="text-gray-600">Yes, you can cancel or modify a booking up to 24 hours before the scheduled time.</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">What payment methods do you accept?</h3>
                <p class="text-gray-600">We accept all major credit cards, PayPal, and other secure payment methods.</p>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="py-12 px-6 bg-blue-50 rounded-lg">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">What Our Users Say</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="text-center">
                <p class="italic text-gray-600 mb-4">"The service was excellent! I found exactly what I needed, and the booking process was seamless. Highly recommend!"</p>
                <p class="text-blue-600 font-semibold">— Sarah K.</p>
            </div>
            <div class="text-center">
                <p class="italic text-gray-600 mb-4">"The platform is user-friendly, and the customer support is incredibly responsive."</p>
                <p class="text-blue-600 font-semibold">— John D.</p>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="mt-12 text-center">
        <a href="/signup" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-blue-700">
            Get Started Now
        </a>
    </div>
</div>
@endsection

@section('customJs')
<!-- Optional JavaScript can go here -->
@endsection
