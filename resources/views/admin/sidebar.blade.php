<div class="shadow-lg mb-4 p-3 bg-white rounded-lg">
    <div class="s-body text-center mt-3">
        <div class="flex justify-center">
            @if (Auth::user()->image != '')
                <img src="{{ asset('profile_pic/' . Auth::user()->image) }}" alt="avatar" class="rounded-full h-36 w-36 object-cover transition-transform duration-200 transform hover:scale-105 shadow-lg">
            @else
                <img src="{{ asset('assets/assets/images/avatar7.png') }}" alt="avatar" class="rounded-full h-36 w-36 object-cover transition-transform duration-200 transform hover:scale-105 shadow-lg">
            @endif
        </div>

        <h5 class="mt-3 pb-0 text-lg font-semibold text-gray-800">{{ Auth::user()->name }}</h5>
        <p class="text-muted mb-1 fs-6 text-gray-600">{{ Auth::user()->designation }}</p>
        <div class="d-flex justify-content-center mb-2">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary rounded-lg">Change Profile Picture</button>
        </div>
    </div>
</div>

<div class="bg-white shadow rounded-lg p-4">
    <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center">
        <i class="fas fa-th mr-2 text-blue-500"></i> 
        Dashboard Menu
    </h3>
    
    <!-- Account Menu Links -->
    <ul class="bg-white">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between w-full p-2 text-gray-700 hover:bg-blue-200 rounded transition duration-200 no-underline">
                <div class="flex items-center">
                    <i class="fas fa-tachometer w-4 h-4 mr-2 text-blue-500"></i>
                    <span class="text-sm">Summary</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users') }}" class="flex items-center justify-between w-full p-2 text-gray-700 hover:bg-blue-200 rounded transition duration-200 no-underline">
                <div class="flex items-center">
                    <i class="fas fa-user w-4 h-4 mr-2 text-blue-500"></i>
                    <span class="text-sm">Users</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.jobs') }}" class="flex items-center justify-between w-full p-2 text-gray-700 hover:bg-blue-200 rounded transition duration-200 no-underline">
                <div class="flex items-center">
                    <i class="fas fa-briefcase w-4 h-4 mr-2 text-blue-500"></i> <!-- Icon for jobs -->
                    <span class="text-sm">Jobs</span>
                </div>
            </a>
        </li>
        <li>
            <a href="#" class="flex items-center justify-between w-full p-2 text-gray-700 hover:bg-blue-200 rounded transition duration-200 no-underline">
                <div class="flex items-center">
                    <i class="fas fa-file-alt w-4 h-4 mr-2 text-blue-500"></i> <!-- Icon for job applications -->
                    <span class="text-sm">Job Applications</span>
                </div>
            </a>
        </li>
    </ul>
</div>