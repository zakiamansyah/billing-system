<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vps extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'cpu', 'ram', 'storage', 'status'];

    public function customers() {
        return $this->belongsTo(Customers::class, 'customer_id');
    }
}
