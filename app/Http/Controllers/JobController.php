<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Resources\JobResource; // ✅ Add this line
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // Add this at the top


class JobController extends Controller
{
    protected $fillable = ['user_id','job_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
    public function index()
    {
        $jobs = Job::with('user')->paginate(10);

        return inertia('JobListings', [
            'jobs' => JobResource::collection($jobs),
        ]);
    }
    public function postJob(Request $request)
    {
        // Validate the job data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Store the job
        $job = Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'user_id' => auth()->id(), // Assuming you want to associate jobs with users
        ]);

        return response()->json(['message' => 'Job posted successfully!', 'job' => $job], 200);
    }
 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
        ]);
    
        // Attach the logged-in user to the job
        $job = new Job($validated);
        $job->user_id = Auth::id(); // 👈 This is the fix
        $job->save();
    
        return redirect()->route('jobs.index')->with('success', 'Job posted successfully!');
    }

public function apply(Request $request, Job $job)
{
    // Example logic to associate the authenticated user with the job
    $user = auth()->user();

    // Check if already applied (optional)
    if ($user->appliedJobs()->where('job_id', $job->id)->exists()) {
        return back()->withErrors(['message' => 'You have already applied for this job.']);
    }

    // Save application (you might need to adjust this logic to fit your models)
    $user->appliedJobs()->attach($job->id, [
        'cover_letter' => $request->input('cover_letter'),
        // Handle file uploads if any
    ]);

    return redirect()->route('jobs.index')->with('success', 'Application submitted successfully.');
}



    public function showApplicationForm(Job $job)
{
    return Inertia::render('JobApplyPage', [
        'job' => $job,
    ]);
}

    
}

