<?php

namespace App\Jobs;

use App\Models\Submission;
use App\Models\User;
use App\Mail\SurveyAnsweredMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendSurveyNotificationJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Submission $submission
    ) {}

    public function handle(): void
    {
        $admins = User::where('role', 'admin')
            ->whereNotNull('email_verified_at')
            ->get();

        foreach ($admins as $admin) {

            try {

                Mail::to($admin->email)
                    ->send(new SurveyAnsweredMail($this->submission));

            } catch (\Exception $e) {

                Log::error(
                    'Error enviando correo admin: '
                    . $e->getMessage()
                );
            }
        }
    }
}