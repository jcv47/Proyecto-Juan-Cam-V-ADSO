<?php

namespace App\Mail;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SurveyAnsweredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;

    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

    public function build()
    {
        return $this->subject('Nueva encuesta respondida en Sondar')
                    ->view('emails.survey-answered');
    }
}