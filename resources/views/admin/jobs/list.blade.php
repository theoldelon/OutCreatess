@extends('front.layouts.app')

@section('main')

<section class="section-5 bg-gray-100 py-8">
    <div class="container mx-auto">
        <div class="flex flex-wrap">
            <!-- Sidebar -->
            <div class="w-full lg:w-1/4 mb-6 lg:mb-0">
                @include('admin.sidebar')
            </div>

            <!-- Main Content -->
            <div class="w-full lg:w-3/4 pl-4">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-2xl font-semibold mb-4 text-gray-800">Job Management</h3>

                    <div id="message-container" class="hidden fixed top-4 left-1/2 transform -translate-x-1/2 p-4 rounded-md z-50 transition duration-300">
                        <span id="message-text"></span>
                    </div>
                
                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse">
                            <thead class="bg-gray-200">
                                <tr class="text-left text-base">
                                    <th class="py-3 px-4 font-semibold text-gray-600 border-b">ID</th>
                                    <th class="py-3 px-4 font-semibold text-gray-600 border-b">Title</th>
                                    <th class="py-3 px-4 font-semibold text-gray-600 border-b">Created By</th>
                                    <th class="py-3 px-4 font-semibold text-gray-600 border-b">Date</th>
                                    <th class="py-3 px-4 font-semibold text-gray-600 border-b">Option</th>
                                </tr>
                            </thead>
                            @foreach ($jobs as $job)
                            <tr>
                                <td class="py-3 px-4 border-b">{{ $job->id }}</td>
                                <td class="py-3 px-4 border-b">{{ $job->title }}</td>
                                <td class="py-3 px-4 border-b">{{ $job->user->name }}</td>
                                <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</td>
                                <td class="py-3 px-4 text-right">
                                    <div class="relative inline-block pr-12">
                                        <button class="focus:outline-none text-gray-400 hover:text-gray-600" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                            <i class="material-icons text-base">more_vert</i>
                                        </button>
                                        <ul class="dropdown-menu absolute right-0 mt-1 w-32 bg-white shadow-lg rounded-lg z-10">
                                            <li>
                                                <a href="{{ route('admin.jobs.edit', $job->id) }}" class="block px-3 py-2 text-gray-800 hover:bg-gray-100 text-sm transition"> 
                                                    <i class="material-icons mr-1 text-xs">edit</i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="block px-3 py-2 text-red-600 hover:bg-gray-100 text-sm transition">
                                                    <i class="material-icons mr-1 text-xs">delete</i> Remove
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $jobs->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')
<!-- Optional JavaScript for delete confirmation -->
<script>
/////////////
 const messageDuration = 3000; // Duration in milliseconds (3 seconds)

    function showMessage(message, isError = false) {
        const messageContainer = document.getElementById('message-container');
        const messageText = document.getElementById('message-text');

        // Set the message text and styling
        messageText.innerText = message;
        messageContainer.className = `fixed top-4 left-1/2 transform -translate-x-1/2 p-4 rounded-md z-50 transition duration-300 ${isError ? 'bg-red-500' : 'bg-green-500'} text-white`;
        
        // Show the message
        messageContainer.classList.remove('hidden');

        // Hide the message after the specified duration
        setTimeout(() => {
            messageContainer.classList.add('hidden');
        }, messageDuration);
    }

    // Trigger success or error message if set in the session
    @if (session('success'))
        showMessage("{{ session('success') }}");
    @elseif (session('error'))
        showMessage("{{ session('error') }}", true);
    @endif

//////////////

    function deleteUser(id) {
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: '{{ route("admin.users.destroy", '') }}/' + id,  // URL with user ID
                type: 'POST',  // Use POST method, and spoof DELETE with _method
                data: {
                    _method: 'DELETE',  // Spoof the DELETE method
                    _token: '{{ csrf_token() }}',  // Include CSRF token for security
                    id: id  // Pass the user ID to the server
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        alert('User deleted successfully');
                        window.location.href = '{{ route("admin.users") }}';  // Redirect to user list
                    } else {
                        alert('User not found');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error deleting user: ' + error);
                }
            });
        }
    }
</script>
@endsection

