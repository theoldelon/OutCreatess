<div class="shadow-lg mb-4 p-3">
    <div class="s-body text-center mt-3">
        <div class="flex justify-center">
            @if (Auth::user()->image != '')
                <img src="{{ asset('profile_pic/' . Auth::user()->image) }}" alt="avatar" class="rounded-full h-36 w-36 object-cover transition-transform duration-200 transform hover:scale-105">
            @else
                <img src="{{ asset('assets/assets/images/avatar7.png') }}" alt="avatar" class="rounded-full h-36 w-36 object-cover transition-transform duration-200 transform hover:scale-105">
            @endif
        </div>

        <h5 class="mt-3 pb-0 text-lg font-semibold">{{ Auth::user()->name }}</h5>
        <p class="text-muted mb-1 fs-6">{{ Auth::user()->designation }}</p>
        <div class="d-flex justify-content-center mb-2">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">Change Profile Picture</button>
        </div>
    </div>
</div>

<div class="bg-white shadow rounded p-4">
    <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center">
        <i class="fas fa-user-cog mr-2 text-blue-500"></i> 
        Account Menu
    </h3>
    
    <!-- Account Menu Links -->
    <ul class="bg-white">
        <li>
            <a href="{{ route('account.profile') }}" class="flex items-center justify-between w-full p-2 text-gray-700 hover:bg-blue-200 rounded transition duration-200 no-underline">
                <div class="flex items-center">
                    <i class="fas fa-cog w-4 h-4 mr-2 text-blue-500"></i>
                    <span class="text-sm">Account Settings</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('account.createJob') }}" class="flex items-center justify-between w-full p-2 text-gray-700 hover:bg-blue-200 rounded transition duration-200 no-underline">
                <div class="flex items-center">
                    <i class="fas fa-plus-circle w-4 h-4 mr-2 text-blue-500"></i>
                    <span class="text-sm">Post a Job</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('account.myJobs') }}" class="flex items-center justify-between w-full p-2 text-gray-700 hover:bg-blue-200 rounded transition duration-200 no-underline">
                <div class="flex items-center">
                    <i class="fas fa-briefcase w-4 h-4 mr-2 text-blue-500"></i>
                    <span class="text-sm">My Jobs</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('account.savedJobs') }}" class="flex items-center justify-between w-full p-2 text-gray-700 hover:bg-blue-200 rounded transition duration-200 no-underline">
                <div class="flex items-center">
                    <i class="fas fa-heart w-4 h-4 mr-2 text-blue-500"></i>
                    <span class="text-sm">Saved Jobs</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('account.myJobApplications') }}" class="flex items-center justify-between w-full p-2 text-gray-700 hover:bg-blue-200 rounded transition duration-200 no-underline">
                <div class="flex items-center">
                    <i class="fas fa-file-alt w-4 h-4 mr-2 text-blue-500"></i>
                    <span class="text-sm">Jobs Applied</span>
                </div>
            </a>
        </li>

    </ul>
</div>
