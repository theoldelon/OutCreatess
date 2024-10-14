<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Notification Email</title>
    <style>
        /* Include Tailwind CSS CDN */
        @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md mt-10">
        <h1 class="text-2xl font-bold text-gray-700">New Job Application</h1>

        <p class="mt-4 text-gray-600">
            Hello {{ $mailData['employer']->name }},
        </p>
        <p class="mt-2 text-gray-600">
            {{ $mailData['user']->name }} has applied for your job position:
            <strong>{{ $mailData['job']->title }}</strong>.
        </p>

        <!-- Employer Details -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-700">Employer Details</h2>
            <p class="mt-2 text-gray-600"><strong>Name: </strong> {{ $mailData['employer']->name }}</p>
            <p class="mt-2 text-gray-600"><strong>Email: </strong> {{ $mailData['employer']->email }}</p>
            @if (!empty($mailData['employer']->mobile))
                <p class="mt-2 text-gray-600"><strong>Mobile: </strong> {{ $mailData['employer']->mobile }}</p>
            @endif
            @if (!empty($mailData['employer']->company))
                <p class="mt-2 text-gray-600"><strong>Company:</strong> {{ $mailData['employer']->company }}</p>
            @endif
        </div>

        <p class="mt-4 text-gray-600">
            You can review the application in your dashboard. If you have any questions, feel free to get in touch.
        </p>

        <p class="mt-4 text-gray-600">
            Thank you for using our platform.
        </p>

        <p class="mt-8 text-sm text-gray-500">
            Best regards,<br>
            The Out Create Team
        </p>

        <hr class="mt-6">
        <p class="text-xs text-gray-400 mt-4">
            If you’re having trouble clicking the link, copy and paste the URL into your web browser.
        </p>
    </div>
</body>
</html>
