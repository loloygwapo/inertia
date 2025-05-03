<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Job;

class JobPolicy
{
    public function apply(User $user, Job $job)
    {
        return $user->role === 'job_seeker';
    }
}
