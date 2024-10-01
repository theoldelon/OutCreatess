<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\JobType;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

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
    
        // Pass the job object to the view
        return view('front.jobDetail', ['job' => $job]);
    }

    public function applyJob(Request $request) {
        $id = $request->id;

        $job = Job::where('id',$id)->first();

        // If job not found in db
        if ($job == null) {
            $message = 'Job does not exist.';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        // you can not apply on your own job
        $employer_id = $job->user_id;

        if ($employer_id == Auth::user()->id) {
            $message = 'You can not apply on your own job.';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        // You can not apply on a job twise
        $jobApplicationCount = JobApplication::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();
        
        if ($jobApplicationCount > 0) {
            $message = 'You already applied on this job.';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();


        // Send Notification Email to Employer
        $employer = User::where('id',$employer_id)->first();
        
        $mailData = [
            'employer' => $employer,
            'user' => Auth::user(),
            'job' => $job,
        ];


        $message = 'You have successfully applied.';

        session()->flash('success',$message);

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
    
}
