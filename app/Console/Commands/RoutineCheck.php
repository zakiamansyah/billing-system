<?php

namespace App\Console\Commands;

use App\Services\BillingSystem;
use Illuminate\Console\Command;

class RoutineCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routine:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $billingService = new BillingSystem();
        $this->info('Starting routine checks...');
        $billingService->routineChecks();
        $this->info('Routine checks completed.');
    }
}
