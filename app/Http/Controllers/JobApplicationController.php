<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\Controller; // ✅ Add this line

class JobApplicationController extends Controller
{
    public function store(Request $request, Job $job)
{
    $this->authorize('apply', $job); // This checks JobPolicy@apply

    $user = $request->user();

    if ($job->applications()->where('user_id', $user->id)->exists()) {
        return redirect()->back()->with('error', 'You have already applied to this job.');
    }

    $job->applications()->create(['user_id' => $user->id]);

    return redirect()->back()->with('success', 'Your application has been submitted.');
}
}
