<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    public $timestamps = true;

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class, 'code', 'code');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
