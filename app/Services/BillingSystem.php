<?php

namespace App\Services;

use App\Models\Customers;
use App\Models\Vps;
use App\Notifications\LowBalanceNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class BillingSystem
{
    public function createVps(Customers $customer, $cpu, $ram, $storage)
    {
        $initialCost = $this->calculateInitialCost($cpu, $ram, $storage);

        if ($customer->balance < $initialCost) {
            throw new \Exception('Insufficient balance to create VPS.');
        }

        DB::beginTransaction();

        try {
            $customer->balance -= $initialCost;
            $customer->save();

            Vps::create([
                'customer_id' => $customer->id,
                'cpu' => $cpu,
                'ram' => $ram,
                'storage' => $storage,
                'status' => 'active',
                'created_at' => Carbon::now(),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function hourlyBilling()
    {
        $vpsList = Vps::where('status', 'active')->get();

        foreach ($vpsList as $vps) {
            $customer = $vps->customer;
            $hourlyCost = $this->calculateHourlyCost($vps->cpu, $vps->ram, $vps->storage);

            DB::beginTransaction();

            try {
                // Deduct hourly cost from customer balance
                $customer->balance -= $hourlyCost;
                $customer->save();

                // Log billing entry
                $vps->billingLogs()->create([
                    'amount' => $hourlyCost,
                    'timestamp' => Carbon::now(),
                ]);

                // Suspend VPS if balance goes negative
                if ($customer->balance < 0) {
                    $vps->status = 'suspended';
                    $vps->save();
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

            $this->checkLowBalance($customer);
        }
    }

    public function routineChecks()
    {
        $customers = Customers::all();

        foreach ($customers as $customer) {
            try {
                $currentMonthCost = $this->calculateMonthlyCost($customer);

                if ($customer->balance < ($currentMonthCost * 0.1)) {
                    Notification::send($customer, new LowBalanceNotification());
                }
            } catch (\Exception $e) {
                // Log error or handle exception
                continue;
            }
        }
    }

    private function calculateInitialCost($cpu, $ram, $storage)
    {
        return ($cpu * 2) + ($ram * 1.5) + ($storage * 0.5);
    }

    private function calculateHourlyCost($cpu, $ram, $storage)
    {
        return ($cpu * 0.2) + ($ram * 0.15) + ($storage * 0.05);
    }

    private function calculateMonthlyCost(Customers $customer)
    {
        return $customer->vps->sum(function ($vps) {
            return $vps->billingLogs->whereBetween('timestamp', [
                Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()
            ])->sum('amount');
        });
    }

    private function checkLowBalance(Customers $customer)
    {
        $currentMonthCost = $this->calculateMonthlyCost($customer);

        if ($customer->balance < ($currentMonthCost * 0.1)) {
            Notification::send($customer, new LowBalanceNotification());
        }
    }
}
