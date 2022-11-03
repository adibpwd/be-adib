<?Php

namespace App\Repositories;

use App\Models\Blok;

class BlokRepository 
{
    protected $blok;

    public function __construct(Blok $blok)
    {
        $this->blok = $blok;
    }

    public function findByIDWithParkingVehicle($id)
    {
        return $this->blok
                    ->withCount('parking_vehicle')
                    ->find($id);
    }

    public function getDetailSlotBlokByName($name)
    {
        return $this->blok
                ->where('name', $name)
                ->withCount('parking_vehicle')
                ->first();
    }
}