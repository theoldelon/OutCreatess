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
                    <div class="card-body p-5">
                        <div id="message-container" class="hidden fixed top-4 left-1/2 transform -translate-x-1/2 p-4 rounded-md z-50 transition duration-300">
                            <span id="message-text"></span>
                        </div>
                        <h3 class="text-lg font-semibold mb-4">My Profile</h3>
                        
                        <!-- Profile Information Display -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Name -->
                                <div class="flex items-center border-b pb-4">
                                    <span class="material-icons mr-3 text-primary">person</span>
                                    <div>
                                        <label class="font-medium">Name</label>
                                        <p class="text-muted">{{ $user->name }}</p>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="flex items-center border-b pb-4">
                                    <span class="material-icons mr-3 text-primary">email</span>
                                    <div>
                                        <label class="font-medium">Email</label>
                                        <p class="text-muted">{{ $user->email }}</p>
                                    </div>
                                </div>

                                <!-- Designation -->
                                <div class="flex items-center border-b pb-4">
                                    <span class="material-icons mr-3 text-primary">work</span>
                                    <div>
                                        <label class="font-medium">Designation</label>
                                        <p class="text-muted">{{ $user->designation }}</p>
                                    </div>
                                </div>

                                <!-- Hourly Rate -->
                                <div class="flex items-center border-b pb-4">
                                    <span class="material-icons mr-3 text-primary">attach_money</span>
                                    <div>
                                        <label class="font-medium">Hourly Rate</label>
                                        <p class="text-muted">${{ number_format($user->hourly_rate, 2) }} / hr</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Mobile -->
                                <div class="flex items-center border-b pb-4">
                                    <span class="material-icons mr-3 text-primary">phone</span>
                                    <div>
                                        <label class="font-medium">Mobile</label>
                                        <p class="text-muted">{{ $user->mobile }}</p>
                                    </div>
                                </div>

                                <!-- Availability -->
                                <div class="flex items-center border-b pb-4">
                                    <span class="material-icons mr-3 text-primary">event_available</span>
                                    <div>
                                        <label class="font-medium">Availability</label>
                                        <p class="text-muted">
                                            @if($user->availability === 'available') Available
                                            @elseif($user->availability === 'unavailable') Unavailable
                                            @else Busy
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Website -->
                                <div class="flex items-center border-b pb-4">
                                    <span class="material-icons mr-3 text-primary">language</span>
                                    <div>
                                        <label class="font-medium">Website</label>
                                        <p class="text-muted">
                                            @if($user->website)
                                                <a href="{{ $user->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $user->website }}</a>
                                            @else
                                                Not Provided
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="my-6 border-t"></div>

                        <!-- Additional Information Section -->
                        <div class="space-y-6">
                            <!-- Bio -->
                            <div class="border-b pb-4">
                                <label class="font-medium text-primary">Bio</label>
                                <p class="text-muted mt-2">{{ $user->bio ?? 'Not Provided' }}</p>
                            </div>

                            <!-- Skills -->
                            <div class="border-b pb-4">
                                <label class="font-medium text-primary">Skills</label>
                                <p class="text-muted mt-2">{{ $user->skills ?? 'Not Provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
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
</script>
@endsection
