<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingVehicle extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = ['timestamps'];
}
