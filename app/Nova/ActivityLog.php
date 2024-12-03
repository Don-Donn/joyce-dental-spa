<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;

class ActivityLog extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ActivityLog::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $group = '2Events'; // Sidebar group

    public static $title = 'action';

    public static function label()
    {
        return 'Activity Logs'; // Plural label
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', // Allows searching by the activity log ID
        'actionable_id', // Allows searching by the ID of the related target
        'changes', // Allows searching for keywords in the changes column
        'name', // Allows searching for the action name (e.g., Create, Update, Delete)
    ];

    /**
     * Disable creation of Activity Logs.
     */
    public static function authorizedToCreate(Request $request)
    {
        return false; // Disable "Add Activity Log"
    }

    /**
     * Disable editing of Activity Logs.
     */
    public function authorizedToUpdate(Request $request)
    {
        return false; // Disable "Edit"
    }

    /**
     * Disable deletion of Activity Logs.
     */
    public function authorizedToDelete(Request $request)
    {
        return false; // Disable "Delete"
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    
     public function fields(Request $request)
     {
         return [
             // Action performed (e.g., Add, Edit, Delete)
             Text::make('Action', 'name')->sortable(),
     
             // Target of the action with meaningful details (e.g., Patient Name or Service Description)
             Text::make('Target', function () {
                 // Attempt to dynamically resolve the target
                 if (class_exists($this->actionable_type) && $this->actionable_id) {
                     $model = app($this->actionable_type)::find($this->actionable_id);
     
                     if ($model) {
                         // Customize display based on the model type
                         if ($this->actionable_type === 'App\Models\Appointment') {
                             return "Appointment: {$model->patient->name}";
                         } elseif ($this->actionable_type === 'App\Models\User') {
                             if ($model->type === 'Patient') {
                                 return "Patient Account: {$model->name}";
                             } elseif ($model->type === 'Staff') {
                                 return "Staff Account: {$model->name}";
                             } elseif ($model->type === 'Administrator') {
                                 return "Administrator Account: {$model->name}";
                             }
                         } elseif ($this->actionable_type === 'App\Models\DentalRecord') {
                             return "Dental Record: {$model->user->name}";
                         } elseif ($this->actionable_type === 'App\Models\DentitionStatus') {
                             return "Dentition Status: {$model->record->user->name}";
                         } elseif ($this->actionable_type === 'App\Models\Service') {
                             return "Service";
                         } elseif ($this->actionable_type === 'App\Models\Treatment') {
                             return "Treatment History: {$model->patient->name}";
                         } elseif ($this->actionable_type === 'App\Models\Xray') {
                             return "X-Ray: {$model->patient->name}";
                         } elseif ($this->actionable_type === 'App\Models\TreatmentType') {
                             return "Treatment Type: {$model->name}";
                         } elseif ($this->actionable_type === 'App\Models\BotResponse') {
                             return "Chatbot Response";
                         }
                     }
                 }
     
                // For deleted records, use data from the `changes` column
                $changes = json_decode($this->changes, true);

                if (is_array($changes)) {
                    // Extract the name and type from the changes data
                    $name = $changes['name'] ?? $changes['attributes']['name'] ?? 'Unknown Name';
                    $type = $changes['type'] ?? ucfirst(class_basename($this->actionable_type));

                    // Include additional details if available
                    $attributes = collect($changes['attributes'] ?? [])->map(function ($value, $key) {
                        return "{$key}: {$value}";
                    })->implode(', ');

                    return "{$type}: {$name} (Deleted)";
                }

                // Fallback for unknown targets
                $type = ucfirst(class_basename($this->actionable_type)) ?? 'Unknown Target';
                return "{$type} (Deleted)";

             })->sortable(),
     
             // Who performed the action
             Text::make('Performed By', function () {
                 $user = \App\Models\User::find($this->user_id); // Fetch the user by ID
                 return $user ? "{$user->name}" : 'Unknown User'; // Display the name or 'Unknown User'
             })->sortable(),
     
             // Role of the user who performed the action
             Text::make('Role', function () {
                 $user = \App\Models\User::find($this->user_id); // Fetch the user by ID
                 return $user ? $user->type : 'Unknown Role'; // Display the role or 'Unknown Role'
             })->sortable(),
     
             // Date and time the action happened
             DateTime::make('Happened At', 'created_at')->sortable(),
         ];
     }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
