<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\SlotCount;
use App\Notifications\NewAppointment;
use Illuminate\Support\Facades\DB;

class AppointmentObserver
{
    public function created(Appointment $appointment)
    {
        // Notify administrators and staff
        $users = User::whereIn('type', ['Administrator', 'Staff'])->get();
        foreach ($users as $user) {
            $user->notify(new NewAppointment($appointment));
        }

        DB::transaction(function () use ($appointment) {
            // Count valid appointments for this date
            $actualCount = Appointment::whereDate('date', $appointment->date)
                ->whereNotNull('slot') // Only count appointments with valid slots
                ->count();
    
            SlotCount::updateOrCreate(
                ['date' => $appointment->date],
                ['count' => $actualCount]
            );
        });
    }

    public function updated(Appointment $appointment)
    {
        if (in_array($appointment->status, ['Cancelled', 'Rejected'])) {
            $appointment->withoutEvents(function () use ($appointment) {
                $appointment->update(['slot' => null]);
            });
    
            // Recalculate SlotCount for the affected date
            DB::transaction(function () use ($appointment) {
                $actualCount = Appointment::whereDate('date', $appointment->date)
                    ->whereNotNull('slot') // Only count valid slots
                    ->count();
    
                SlotCount::updateOrCreate(
                    ['date' => $appointment->date],
                    ['count' => $actualCount]
                );
            });
        }
    }
    
    public function deleted(Appointment $appointment)
    {
        // Recalculate SlotCount for the affected date
        DB::transaction(function () use ($appointment) {
            $actualCount = Appointment::whereDate('date', $appointment->date)
                ->whereNotNull('slot') // Only count valid slots
                ->count();
    
            SlotCount::updateOrCreate(
                ['date' => $appointment->date],
                ['count' => $actualCount]
            );
        });
    }
    

    public function restored(Appointment $appointment)
    {
        // Re-add to SlotCount
        DB::transaction(function () use ($appointment) {
            $slotCount = SlotCount::whereDate('date', $appointment->date)->lockForUpdate()->first();

            if (!$slotCount) {
                SlotCount::create([
                    'date' => $appointment->date,
                    'count' => 1,
                ]);
            } else {
                $slotCount->increment('count');
            }
        });
    }

    public function forceDeleted(Appointment $appointment)
    {
        // Decrement SlotCount
        DB::transaction(function () use ($appointment) {
            $slotCount = SlotCount::whereDate('date', $appointment->date)->lockForUpdate()->first();

            if ($slotCount && $slotCount->count > 0) {
                $slotCount->decrement('count');
            }
        });
    }
}
