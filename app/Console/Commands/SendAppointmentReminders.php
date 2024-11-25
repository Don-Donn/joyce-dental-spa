<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Mail\AppointmentReminder;
use Illuminate\Support\Facades\Mail;

class SendAppointmentReminders extends Command
{
    // Command signature for scheduling
    protected $signature = 'reminders:send';

    // Description of the command
    protected $description = 'Send email reminders for appointments scheduled for tomorrow';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get appointments scheduled for tomorrow with status 'Approved'
        $appointments = Appointment::whereDate('date', today()->addDay(1))
            ->where('status', 'Approved') // Filter for 'Approved' status
            ->with('patient')
            ->get();
    
        // Loop through each appointment and send an email
        foreach ($appointments as $appointment) {
            try {
                Mail::to($appointment->patient->email)->send(new AppointmentReminder($appointment));
                $this->info('Reminder sent to: ' . $appointment->patient->email);
            } catch (\Exception $e) {
                $this->error('Failed to send reminder to: ' . $appointment->patient->email . ' - ' . $e->getMessage());
            }
        }
    
        $this->info('All reminders processed.');
    }
    
}
