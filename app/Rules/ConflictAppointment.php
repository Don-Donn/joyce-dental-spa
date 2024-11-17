<?php

namespace App\Rules;

use App\Models\Appointment;
use Illuminate\Contracts\Validation\Rule;

class ConflictAppointment implements Rule
{
    protected $date;
    protected $appointmentId; // Add a property for the current appointment ID

    /**
     * Create a new rule instance.
     *
     * @param  string  $date
     * @param  int|null  $appointmentId
     * @return void
     */
    public function __construct($date, $appointmentId = null)
    {
        $this->date = $date;
        $this->appointmentId = $appointmentId; // Set the current appointment ID
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check for conflicting appointments, excluding the current one if provided
        $exists = Appointment::where('slot', $value)
            ->whereDate('date', $this->date)
            ->when($this->appointmentId, function ($query) {
                $query->where('id', '!=', $this->appointmentId); // Exclude the current appointment
            })
            ->exists();

        return !$exists; // Pass if no conflict exists
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Conflict Schedule.';
    }
}
