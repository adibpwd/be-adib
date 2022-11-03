<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blok extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = ['timestamps'];

    /**
     * Get all of the comments for the Blok
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parking_vehicle(): HasMany
    {
        return $this->hasMany(ParkingVehicle::class, 'blok_id', 'id');
    }
}
