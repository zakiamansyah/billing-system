<?php 

use App\Http\Controllers\Api\BillingController;

Route::post('/billing/create-vps', [BillingController::class, 'createVps']);
Route::post('/billing/hourly-billing', [BillingController::class, 'hourlyBilling']);
Route::post('/billing/routine-checks', [BillingController::class, 'routineChecks']);