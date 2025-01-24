<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    use Notifiable;

    public $timestamps = false;

    protected $table = 'customers';

    protected $fillable = [
        "name",
        "email",
        "balance"
    ];

    public function vps()
    {
        return $this->hasMany(Vps::class);
    }
}
