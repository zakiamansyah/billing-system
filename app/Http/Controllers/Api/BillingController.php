<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Services\BillingSystem;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    protected $billingService;

    public function __construct(BillingSystem $billingService)
    {
        $this->billingService = $billingService;
    }

    public function createVps(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required',
            'cpu' => 'required|integer|min:1',
            'ram' => 'required|integer|min:1',
            'storage' => 'required|integer|min:1',
        ]);

        $customer = Customers::find($validated['customer_id']);

        if (!$customer) {
            return response()->json(['error' => 'Customer not found.'], 404);
        }

        try {
            $this->billingService->createVps(
                $customer,
                $validated['cpu'],
                $validated['ram'],
                $validated['storage']
            );

            return response()->json(['message' => 'VPS created successfully'], 201);
        } catch (\Exception $e) {
            \Log::error('Error creating VPS: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function hourlyBilling()
    {
        try {
            $this->billingService->hourlyBilling();
            return response()->json(['message' => 'Hourly billing completed successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Error in hourly billing: ' . $e->getMessage());
            return response()->json(['error' => 'Error in hourly billing'], 500);
        }
    }

    public function routineChecks()
    {
        try {
            $this->billingService->routineChecks();
            return response()->json(['message' => 'Routine checks completed successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Error in routine checks: ' . $e->getMessage());
            return response()->json(['error' => 'Error in routine checks'], 500);
        }
    }
}
