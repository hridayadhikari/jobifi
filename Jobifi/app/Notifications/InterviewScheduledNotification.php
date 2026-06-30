<?php

namespace App\Notifications;

use App\Models\InterviewSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InterviewScheduledNotification extends Notification
{
    use Queueable;

    public function __construct(
        public InterviewSchedule $interview
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'notification_key' => 'interview-' . $this->interview->id,

            'title' => 'Interview Scheduled',

            'message' => 'Your interview for "' .
                $this->interview->application->job->title .
                '" has been scheduled.',

            'interview_id' => $this->interview->id,

            'application_id' => $this->interview->application_id,
        ];
    }
}