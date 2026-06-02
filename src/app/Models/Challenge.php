<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'title',
        'description',
        'target_hours',
        'duration_weeks',
        'badge_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_challenges')
            ->withPivot('status', 'progress_hours', 'joined_at', 'completed_at')
            ->withTimestamps();
    }
}
