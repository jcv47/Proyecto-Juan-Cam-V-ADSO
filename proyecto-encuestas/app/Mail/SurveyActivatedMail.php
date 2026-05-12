<?php

namespace App\Mail;

use App\Models\Survey;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SurveyActivatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $survey;

    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }

    public function build()
    {
        return $this->subject('Nueva encuesta disponible en Sondar')
                    ->view('emails.survey-activated');
    }
}