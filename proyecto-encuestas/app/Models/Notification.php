<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'admin_user_id',
        'submission_id',
        'tipo',
        'mensaje',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}