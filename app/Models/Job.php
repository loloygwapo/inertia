<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'user_id',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
    public function index(Request $request)
{
    $jobs = Job::all();
    $user = $request->user();
    $appliedIds = $user->jobApplications()->pluck('job_id')->toArray();
    return Inertia::render('Jobs/Index', [
        'jobs' => $jobs,
        'appliedIds' => $appliedIds,
    ]);
}
}

