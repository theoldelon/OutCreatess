<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    // Optionally, if you have a User model, define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
