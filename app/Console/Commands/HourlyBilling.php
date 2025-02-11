<?php

namespace App\Console\Commands;

use App\Services\BillingSystem;
use Illuminate\Console\Command;

class HourlyBilling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform hourly billing for all active VPS instances';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $billingService = new BillingSystem();
            $billingService->hourlyBilling();
            $this->info('Hourly billing completed successfully.');
        } catch (\Exception $e) {
            \Log::error('Error in hourly billing: ' . $e->getMessage());
            $this->error('An error occurred during hourly billing.');
        }
    }
}
