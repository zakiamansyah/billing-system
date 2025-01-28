<?php

use App\Services\BillingSystem;
use Illuminate\Support\Facades\Artisan;

Artisan::command('billing:hourly', function () {
    try {
        $billingService = new BillingSystem();
        $billingService->hourlyBilling();
        $this->info('Hourly billing completed successfully.');
    } catch (\Exception $e) {
        \Log::error('Error in hourly billing: ' . $e->getMessage());
        $this->error('An error occurred during hourly billing.');
    }
})->hourly();

Artisan::command('routine:check', function () {
    $billingService = new BillingSystem();
    $this->info('Starting routine checks...');
    $billingService->routineChecks();
    $this->info('Routine checks completed.');
})->hourly();
