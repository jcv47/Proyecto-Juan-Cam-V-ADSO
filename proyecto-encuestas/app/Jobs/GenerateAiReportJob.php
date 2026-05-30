<?php

namespace App\Jobs;

use App\Models\Submission;
use App\Models\AiReport;
use App\Services\AiAnalyzer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;

class GenerateAiReportJob implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Submission $submission
    ) {}

    public function handle(AiAnalyzer $aiAnalyzer): void
    {
        $this->submission->load('answers.question');

        $result = $aiAnalyzer->analyze($this->submission);

        AiReport::updateOrCreate(
            [
                'submission_id' => $this->submission->id
            ],
            [
                'sentiment' => $result['sentiment'],
                'severity' => $result['severity'],
                'summary' => $result['summary'],
                'improvements' => $result['improvements'] ?? [],
            ]
        );
    }
}