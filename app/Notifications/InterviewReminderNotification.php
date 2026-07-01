<?php

namespace App\Notifications;

use App\Models\InterviewSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InterviewReminderNotification extends Notification
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
        'notification_key' => 'interview-reminder-' . $this->interview->id,

        'title' => 'Interview Reminder',

        'message' => 'Reminder: Your interview for "' .
            $this->interview->application->job->title .
            '" is scheduled within the next 24 hours.',

        'type' => 'interview',

        'url' => route('seeker.interviews.show', $this->interview->id),

        'interview_id' => $this->interview->id,

        'application_id' => $this->interview->application_id,

        'job_id' => $this->interview->application->job->id,

        'job_title' => $this->interview->application->job->title,
    ];
}
}