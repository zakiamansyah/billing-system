<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vps extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = ['customer_id', 'cpu', 'ram', 'storage', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }
}
