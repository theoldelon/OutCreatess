<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;

class AccountController extends Controller
{
    public function registration()
    {
        return view('front.account.registration');
    }

    public function processRegistration(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:7|confirmed', // 'confirmed' works with password_confirmation field
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        // If validation passes, create a new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        // Flash success message
        session()->flash('success', 'You have registered successfully!');

        // Return success response
        return response()->json([
            'status' => true,
        ]);
    }

    public function login()
    {
        return view('front.account.login');
    }

    public function authenticate(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Attempt to log the user in
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->route('account.profile'); // Change to your intended route
        } else {
            // Authentication failed
            return redirect()->back()->with('error', 'Invalid login credentials');
        }
    }

    public function profile()
    {
        $id = Auth::user()->id;

       // $user = User::where('id', $id)->first();
       $user = User::find($id);

        return view('front.account.profile',[
            'user' => $user,
            
        ]);
    }

    public function updateProfile(Request $request)
    {

        $id = Auth::user()->id;

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        if ($validator->passes()) 
        {

            session()->flash('success', 'Profile updated!');

            $user = User::find($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->mobile = $request->input('mobile');
            $user->designation = $request->input('designation');
            $user->hourly_rate = $request->input('hourly_rate');
            $user->availability = $request->input('availability');
            $user->bio = $request->input('bio');
            $user->skills = $request->input('skills');
            $user->website = $request->input('website');
            $user->save();
            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        }
        else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }

public function updateProfilePic(Request $request)
{

    $id = Auth::user()->id;
    $validator = Validator::make($request->all(),[
        'image' => 'required|image',
    ]);

    if ($validator->passes())
    {
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = $id.'-'.time().'.'.$ext;
        $image->move(public_path('/profile_pic'), $imageName);

        // Delete Old Profile Pic

        File::delete(public_path('/profile_pic/thumb/'.Auth::user()->image));
        File::delete(public_path('/profile_pic'.Auth::user()->image));

        User::where('id', $id)->update(['image' => $imageName]);

        session()->flash('success', 'Profile picture updated!');

        return response()->json([
            'status' => true,
            'errors' => '',
        ]);
    } else {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }
}

public function createJob()
{

    $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
    $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

    return view('front.account.job.create',[
        'categories' => $categories,
        'jobTypes' => $jobTypes
    ]);
}

public function saveJob(Request $request)
{
    $rules = [
        'title' => 'bail|required|string|max:255',
        'category_id' => 'bail|required|integer|exists:categories,id',
        'job_type_id' => 'bail|required|integer|exists:job_types,id',
        'vacancy' => 'bail|required|integer|min:1',
        'salary' => 'bail|required|numeric|min:0|max:1000000',
        'location' => 'bail|required|string|max:255',
        'description' => 'bail|required|string|min:20',   
        'benefits' => 'nullable|string|max:1000',
        'responsibility' => 'nullable|string|max:2000', 
        'qualifications' => 'nullable|string|max:2000',
        'keywords' => 'nullable|string|max:500',
        'experience' => 'nullable|integer|min:0|max:50',
        'company_name' => 'bail|required|string|max:255',
        'company_location' => 'bail|required|string|max:255',
        'company_website' => 'nullable|url|regex:/^https?:\/\/[^\s$.?#].[^\s]*$/i',
    ];
    

    $validator = Validator::make($request->all(), $rules);

    // Check if the validation fails
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }

    // Create a new job
    $job = new Job();
    $job->title = $request->title;
    $job->category_id = $request->category_id; // Ensure you use the correct key
    $job->job_type_id = $request->job_type_id; // Ensure you use the correct key
    $job->user_id = Auth::user()->id;
    $job->vacancy = $request->vacancy;
    $job->salary = $request->salary;
    $job->location = $request->location;
    $job->description = $request->description;
    $job->benefits = $request->benefits;
    $job->responsibility = $request->responsibility;
    $job->qualifications = $request->qualifications;
    $job->keywords = $request->keywords;
    $job->experience = $request->experience;
    $job->company_name = $request->company_name;
    $job->company_location = $request->company_location;
    $job->company_website = $request->company_website;

    // Save the job to the database
    $job->save();

    session()->flash('success', 'Job added!');

    return response()->json([
        'status' => true,
        'errors' => [],
    ]);
}


public function myJobs()
{

    $jobs = Job::where('user_id', Auth::user()->id)->with('jobType')->orderBy('created_at', 'DESC')->paginate(10);
    return view('front.account.job.my-jobs',[
        'jobs' => $jobs,

    ]);
}

public function editJob(Request $request, $id)
{
    // Fetch categories and job types that are active
    $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
    $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

    // Retrieve the job posted by the authenticated user
    $job = Job::where([
        'user_id' => Auth::user()->id,
        'id' => $id,
    ])->first();

    if ($job == null)
    {
        abort(404);
    }
    // Return the view and pass the job, categories, and job types
    return view('front.account.job.edit', [
        'categories' => $categories,
        'jobTypes' => $jobTypes,
        'job' => $job,
    ]);
}
public function updateJob(Request $request ,$id)
{
    $rules = [
        'title' => 'required|string|max:255',
        'category_id' => 'required|integer',
        'job_type_id' => 'required|integer',
        'vacancy' => 'required|integer|min:1',
        'salary' => 'required|numeric',
        'location' => 'required|string|max:255',
        'description' => 'required|string',
        'benefits' => 'nullable|string',
        'responsibility' => 'nullable|string',
        'qualifications' => 'nullable|string',
        'keywords' => 'nullable|string',
        'experience' => 'nullable|integer|min:0',
        'company_name' => 'required|string|max:255',
        'company_location' => 'required|string|max:255',
        'company_website' => 'nullable|url',
    ];

    $validator = Validator::make($request->all(), $rules);

    // Check if the validation fails
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }

    // Create a new job
    $job = Job::find($id);
    $job->title = $request->title;
    $job->category_id = $request->category_id; // Ensure you use the correct key
    $job->job_type_id = $request->job_type_id; // Ensure you use the correct key
    $job->user_id = Auth::user()->id;
    $job->vacancy = $request->vacancy;
    $job->salary = $request->salary;
    $job->location = $request->location;
    $job->description = $request->description;
    $job->benefits = $request->benefits;
    $job->responsibility = $request->responsibility;
    $job->qualifications = $request->qualifications;
    $job->keywords = $request->keywords;
    $job->experience = $request->experience;
    $job->company_name = $request->company_name;
    $job->company_location = $request->company_location;
    $job->company_website = $request->company_website;

    // Save the job to the database
    $job->save();

    session()->flash('success', 'Job updated!');

    return response()->json([
        'status' => true,
        'errors' => [],
    ]);
}

public function deleteJob(Request $request)
{
    $job = Job::where([
        'user_id' => Auth::user()->id,
        'id' => $request->jobId,
    ])->first();

    // Check if the job exists
    if ($job == null) {
        return response()->json([
            'status' => false,
            'message' => 'Job not found!'
        ], 404); // Return a 404 Not Found response
    }

    // Delete the job
    $job->delete(); // This is more concise than using where and then delete
    return response()->json([
        'status' => true,
        'message' => 'Job deleted successfully!'
    ]);
}

public function myJobApplications()
{
    $jobApplications = JobApplication::where('user_id', Auth::user()->id)     
                    ->with(['job', 'job.jobType', 'job.applications'])
                    ->paginate(8);

    return view('front.account.job.my-job-applications', [
        'jobApplications' => $jobApplications,
    ]);
}

public function removeJobs(Request $request)
{
    $jobApplications = JobApplication::where([
                        'id' => $request->id,
                        'user_id' => Auth::user()->id])->first();

    if ($jobApplications == null)
    {            
        session()->flash('error', 'Job application not found!');
        return response()->json([

            'status' => false,
        ]);
    }
    
    JobApplication::find($request->id)->delete();
    session()->flash('success', 'Job application removed!');
    return response()->json([
        'status' => true,
        ]);

}

public function savedJobs()
{
    // Fetch saved jobs for the authenticated user
    $savedJobs = SavedJob::where('user_id', Auth::id()) // Auth::id() gives the ID of the currently logged-in user
                        ->with(['job', 'job.jobType', 'job.applications'])
                        ->orderBy('created_at', 'DESC') 
                        ->paginate(8); // Add pagination if necessary

    // Return the saved jobs view and pass the $savedJobs variable
    return view('front.account.job.saved-job', [
        'savedJobs' => $savedJobs, // Make sure to use the correct variable name here
    ]);
}

public function removeSavedJobs(Request $request)
{
    // Find the saved job by id and user_id
    $savedJob = SavedJob::where([
                        'id' => $request->id,
                        'user_id' => Auth::user()->id])->first();

    // If the saved job is not found
    if ($savedJob == null)
    {            
        session()->flash('error', 'Job not found!');
        return response()->json([
            'status' => false,
        ]);
    }
    
    // Delete the saved job
    $savedJob->delete();

    // Set success message and return response
    session()->flash('success', 'Job unsaved successfully!');
    return response()->json([
        'status' => true,
    ]);
}

public function updatePassword(Request $request) {
    $validator = Validator::make($request->all(), [
        'old_password' => 'required',
        'new_password' => 'required|min:5',
        'confirm_password' => 'required|same:new_password',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    // Check if the old password is correct
    if (!Hash::check($request->old_password, Auth::user()->password)) {
        return response()->json([
            'status' => false,
            'errors' => ['old_password' => 'Your old password is incorrect.'],
        ]);
    }

    // Update password if validation and old password are correct
    $user = User::find(Auth::user()->id);
    $user->password = Hash::make($request->new_password);
    $user->save();

    // Flash success message and return JSON response
    session()->flash('success', 'Password updated successfully.');
    return response()->json([
        'status' => true,
        'message' => 'Password updated successfully.',
    ]);
}

}
