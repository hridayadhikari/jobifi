<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterviewSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'interview_at',
        'meeting_link',
        'notes',
    ];

    protected $casts = [
        'interview_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}