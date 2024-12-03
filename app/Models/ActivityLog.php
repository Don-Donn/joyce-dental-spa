<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'action_events';

    public function causer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
