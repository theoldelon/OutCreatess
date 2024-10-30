@extends('front.layouts.app')

@section('main')

<section class="section-5 bg-gray-100 py-5">
    <div class="container mx-auto">
        <div class="flex flex-wrap">
            <!-- Sidebar -->
            <div class="w-full lg:w-1/4 p-4">
                @include('admin.sidebar')
            </div>

            <!-- Main Content -->
            <div class="w-full lg:w-3/4 p-4">
                <div class="bg-white border border-gray-200 shadow-md rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-center">Welcome Administrator</h3>
                        <p class="text-center text-gray-600 mt-2">Manage your application with ease.</p>
                    </div>
                </div>

                <!-- Additional Stats or Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h4 class="font-semibold text-lg">Total Users</h4>
                        <p class="text-2xl">{{ \App\Models\User::count() }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow">
                        <h4 class="font-semibold text-lg">Total Posts</h4>
                        <p class="text-2xl">{{ \App\Models\Job::count() }}</p> <!-- Ensure the Job model is correctly referenced -->
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow">
                        <h4 class="font-semibold text-lg">Total Types of Jobs</h4>
                        <p class="text-2xl">{{ \App\Models\JobType::count() }}</p> <!-- Ensure the JobType model is correctly referenced -->
                    </div>
                </div>

                <!-- Charts or Other Content -->
                <div class="bg-white border border-gray-200 shadow-md rounded-lg mt-6">
                    <div class="p-6">
                        <h4 class="font-semibold text-lg">User Growth</h4>
                        <div class="h-64 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500">Chart Placeholder</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities Section -->
                <div class="bg-white border border-gray-200 shadow-md rounded-lg mt-6">
                    <div class="p-6">
                        <h4 class="font-semibold text-lg">Recent Activities</h4>
                        <ul class="mt-4">
                            <li class="border-b py-2">User Lee Guy registered.</li>
                            <li class="border-b py-2">Post "Laravel Tips" published.</li>
                            <li class="border-b py-2">Job Type on "PHP vs Python" added.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')
<!-- You can include any custom JS scripts here -->
@endsection
