<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'billing_logs';

    protected $fillable = [
        "vps_id",
        "amount",
        "timestamp"
    ];

    public function vps()
    {
        return $this->belongsTo(Vps::class);
    }
}
