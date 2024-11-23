<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\SlotCount;

class RecalculateSlotCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slotcount:recalculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate SlotCount for all dates based on appointments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dates = Appointment::selectRaw('DATE(date) as date')->groupBy('date')->get();

        foreach ($dates as $date) {
            $actualCount = Appointment::whereDate('date', $date->date)
                ->whereNotNull('slot')
                ->count();

            SlotCount::updateOrCreate(
                ['date' => $date->date],
                ['count' => $actualCount]
            );
        }

        $this->info('SlotCount recalculated for all dates.');

        return 0;
    }
}
