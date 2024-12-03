<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogObserver
{
    public function deleting(Model $model)
    {
        ActivityLog::create([
            'name' => 'Delete', // Action name
            'user_id' => Auth::id(), // The user performing the action
            'actionable_type' => get_class($model), // The model class
            'actionable_id' => $model->id, // The ID of the record being deleted
            'changes' => json_encode([
                'name' => $model->name ?? ($model->title ?? 'No Name Available'), // Use name or title if available
                'type' => class_basename($model), // Class name (e.g., User, Appointment)
                'attributes' => $model->getAttributes(), // All attributes of the deleted record
            ]),
        ]);
    }
    
}



