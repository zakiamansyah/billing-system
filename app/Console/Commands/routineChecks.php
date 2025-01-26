<?php

namespace App\Console\Commands;

use App\Services\BillingSystem;
use Illuminate\Console\Command;

class routineChecks extends Command
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
    protected $description = 'Routine Check billing for all active VPS instances';

    protected $billingService; 
 
    public function __construct(BillingSystem $billingService) 
    { 
        parent::__construct(); 
        $this->billingService = $billingService; 
    } 

    /**
     * Execute the console command.
     */
    public function handle()
    { 
        try { 
            $this->billingService->routineChecks(); 
            $this->info('Routine Check completed successfully.'); 
        } catch (\Exception $e) { 
            \Log::error('Error in hourly billing: ' . $e->getMessage()); 
            $this->error('An error occurred during routine check.'); 
        } 
    } 
}
