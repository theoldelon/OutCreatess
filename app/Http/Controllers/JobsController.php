<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Job;
use App\Models\User;
use App\Models\JobType;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\SavedJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        // Fetch categories and job types with active status
        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();
    
        // Initialize the jobs query with active jobs
        $jobs = Job::where('status', 1);
    
        // Search for jobs by keyword in the title or keywords fields
        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->keyword . '%')
                      ->orWhere('keywords', 'like', '%' . $request->keyword . '%');
            });
        }
    
        // Search by location
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', 'like', '%' . $request->location . '%');
        }
    
        // Search by category
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }
    
        // Search by job type (assuming jobType is a relationship)
        if (!empty($request->jobTypes)) {
            $jobs = $jobs->whereIn('job_type_id', $request->jobTypes);
        }
    
        // Search by experience
        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }
    
        // Load related job type and paginate the results
        $jobs = $jobs->with(['jobType', 'category']);
        
        // Sort results - always sort by latest first
        if ($request->sort == '0') {
            $jobs->orderBy('created_at', 'ASC'); // Oldest first
        } else {
            $jobs->orderBy('created_at', 'DESC'); // Latest first
        }
    
        // Paginate the results
        $jobs = $jobs->paginate(7);
    
        // Pass data to the view
        return view('front.jobs', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
            'jobTypeArray' => $request->jobTypes 
        ]);
    }
    

    public function detail($id)
    {
        $job = Job::where([
                            'id' => $id, 
                            'status' => 1
                        ])->with(['jobType', 'category'])->first();
                        
        if (!$job) {
            // Abort with a 404 error if the job is not found or inactive
            abort(404, 'Job not found or inactive.');
        }
    
        // Count of saved jobs for the authenticated user
        $count = 0;
        if(Auth::user())
        
        {
            $count = SavedJob::where([
                'user_id' => Auth::user()->id,
                'job_id' => $id
            ])->count();
        
        }

        //fetch applicants

        $applications = JobApplication::where('job_id', $id)->with('user')->get();
        // Pass the job object and saved job count to the view
        return view('front.jobDetail', [
            'job' => $job,
            'count' => $count,
            'applications' => $applications
        ]);
    }
    

    public function applyJob(Request $request) {
        $id = $request->id;
    
        // Attempt to retrieve the job
        $job = Job::find($id); // Using find() returns null if not found
    
        // If job not found in db
        if ($job === null) {
            $message = 'Job does not exist.';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
    
        // Check if the job is created by the logged-in user
        $employer_id = $job->user_id;
    
        if ($employer_id == Auth::user()->id) {
            $message = 'You cannot apply to your own job.';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
    
        // Check if the user has already applied for the job
        $jobApplicationCount = JobApplication::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();
    
        if ($jobApplicationCount > 0) {
            $message = 'You have already applied to this job.';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
    
        // Create a new job application
        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();
    
        // Send notification email to employer
        $employer = User::find($employer_id);
        if ($employer && !empty($employer->email)) { // Check if employer exists and has an email
            $mailData = [
                'employer' => $employer,
                'user' => Auth::user(),
                'job' => $job,
            ];
    
            Mail::to($employer->email)->send(new JobNotificationEmail($mailData));
        }
    
        $message = 'You have successfully applied.';
        session()->flash('success', $message);
    
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
    
    public function saveJob(Request $request)
    {
        $id = $request->id;

        $job =  Job::find($id);
        
        if ($job == null)
        {
            $message = 'Job not found.';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        //check the user already saved job

        $count = SavedJob::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();

        if($count > 0)
        {
            $message = 'You already saved this job!';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
        
        $saveJob = new SavedJob();
        $saveJob->user_id = Auth::user()->id;
        $saveJob->job_id = $id;
        $saveJob->save();

        $message = 'You successfully saved this job!';
        session()->flash('success',$message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);

    }
    
}
