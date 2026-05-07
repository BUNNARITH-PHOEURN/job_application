<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'cover_letter',
        'resume_path',
        'resume_original_name',
        'status',
    ];
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
 
    /**
     * Convenience: full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
