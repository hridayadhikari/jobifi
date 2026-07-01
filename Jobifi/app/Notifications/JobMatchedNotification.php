<?php

namespace App\Notifications;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class JobMatchedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Job $job
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

public function toDatabase(object $notifiable): array
{
    return [
        'notification_key' => 'job-match-' . $this->job->id . '-user-' . $notifiable->id,

        'title' => 'New Job Match',

        'message' => 'A new job "' .
            $this->job->title .
            '" matches your skills.',

        'type' => 'job',

        'url' => route('seeker.jobs.show', $this->job->id),

        'job_id' => $this->job->id,

        'company' => $this->job->company->name,

        'job_title' => $this->job->title,
    ];
}
}