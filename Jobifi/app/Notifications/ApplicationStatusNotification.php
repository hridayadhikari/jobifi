<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Application $application
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'notification_key' =>
                'application-status-' .
                $this->application->id .
                '-' .
                strtolower($this->application->status),

            'title' => 'Application Status Updated',

            'message' =>
                'Your application for "' .
                $this->application->job->title .
                '" has been ' .
                ucfirst(strtolower($this->application->status)) .
                '.',

            'application_id' => $this->application->id,

            'job_id' => $this->application->job_id,

            'status' => strtolower($this->application->status),

            'job_title' => $this->application->job->title,
        ];
    }
}