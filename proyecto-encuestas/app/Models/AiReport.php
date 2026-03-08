<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiReport extends Model
{
    protected $fillable = [
        'submission_id',
        'sentiment',
        'severity',
        'summary',
        'improvements',
    ];

    protected $casts = [
        'improvements' => 'array',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}