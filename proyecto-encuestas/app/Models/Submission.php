<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'public_id',
        'survey_id',
        'user_id',
    ];

    public function getRouteKeyName()
    {
        return 'public_id';
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function aiReport()
    {
        return $this->hasOne(AiReport::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}