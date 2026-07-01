<?php

namespace App\Console\Commands;
use App\Models\Application;
use App\Notifications\NewApplicationNotification;
use App\Notifications\ApplicationStatusNotification;
use App\Models\InterviewSchedule;
use App\Notifications\InterviewScheduledNotification;
use App\Notifications\InterviewReminderNotification;
use App\Models\Job;
use App\Models\SeekerProfile;
use App\Notifications\JobMatchedNotification;
use Illuminate\Console\Command;

class ProcessNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
public function handle(): int
{
    $this->processNewApplications();
    $this->processApplicationStatus();
    $this->processInterviewSchedules();
    $this->processInterviewReminders();
    $this->processJobMatchedJobs();

    return self::SUCCESS;
}

private function processNewApplications(): void
{
    $applications = Application::with([
        'user',
        'job.company.user'
    ])->get();

    foreach ($applications as $application) {

        $recruiter = $application->job->company->user;

        if (!$recruiter) {
            continue;
        }

        $notificationKey = 'application-' . $application->id;

        $alreadySent = $recruiter->notifications()
            ->where('type', NewApplicationNotification::class)
            ->whereJsonContains(
                'data->notification_key',
                $notificationKey
            )
            ->exists();

        if ($alreadySent) {
            continue;
        }

        $recruiter->notify(
            new NewApplicationNotification($application)
        );
    }
}

private function processApplicationStatus(): void
{
    $applications = Application::with([
        'user',
        'job'
    ])
    ->where('status', '!=', 'pending')
    ->get();

    foreach ($applications as $application) {

        $user = $application->user;

        $notificationKey =
            'application-status-' .
            $application->id .
            '-' .
            strtolower($application->status);

        $alreadySent = $user->notifications()
            ->where('type', ApplicationStatusNotification::class)
            ->whereJsonContains(
                'data->notification_key',
                $notificationKey
            )
            ->exists();

        if ($alreadySent) {
            continue;
        }

        $user->notify(
            new ApplicationStatusNotification($application)
        );
    }
}

private function processInterviewSchedules(): void
{
    $interviews = InterviewSchedule::with([
        'application.user',
        'application.job'
    ])->get();

    foreach ($interviews as $interview) {

        $seeker = $interview->application->user;

        $notificationKey = 'interview-' . $interview->id;

        $alreadySent = $seeker->notifications()
            ->where('type', InterviewScheduledNotification::class)
            ->whereJsonContains(
                'data->notification_key',
                $notificationKey
            )
            ->exists();

        if ($alreadySent) {
            continue;
        }

        $seeker->notify(
            new InterviewScheduledNotification($interview)
        );
    }
}
private function processInterviewReminders(): void
{
    $now = now();

    $next24Hours = now()->addDay();

    $interviews = InterviewSchedule::with([
        'application.user',
        'application.job'
    ])
    ->whereBetween('interview_at', [$now, $next24Hours])
    ->get();

    foreach ($interviews as $interview) {

        $seeker = $interview->application->user;

        $notificationKey = 'interview-reminder-' . $interview->id;

        $alreadySent = $seeker->notifications()
            ->where('type', InterviewReminderNotification::class)
            ->whereJsonContains(
                'data->notification_key',
                $notificationKey
            )
            ->exists();

        if ($alreadySent) {
            continue;
        }

        $seeker->notify(
            new InterviewReminderNotification($interview)
        );
    }
}
private function processJobMatchedJobs(): void
{
    $jobs = Job::with([
        'skills',
        'company'
    ])
    ->where('is_active', true)
    ->get();

    foreach ($jobs as $job) {

        $jobSkillIds = $job->skills->pluck('id');

        if ($jobSkillIds->isEmpty()) {
            continue;
        }

        $seekers = SeekerProfile::with([
            'user',
            'skills'
        ])->get();

        foreach ($seekers as $profile) {

            if (!$profile->user) {
                continue;
            }

            $seekerSkillIds = $profile->skills->pluck('id');

            // Count matching skills
            $matchedSkills = $jobSkillIds
                ->intersect($seekerSkillIds)
                ->count();

            // Required matches
            $requiredMatches = min(2, $jobSkillIds->count());

            if ($matchedSkills < $requiredMatches) {
                continue;
            }

            $notificationKey = 'job-match-' .
                $job->id .
                '-user-' .
                $profile->user->id;

            $alreadySent = $profile->user->notifications()
                ->where('type', JobMatchedNotification::class)
                ->whereJsonContains(
                    'data->notification_key',
                    $notificationKey
                )
                ->exists();

            if ($alreadySent) {
                continue;
            }

            $profile->user->notify(
                new JobMatchedNotification($job)
            );
        }
    }
}
}
