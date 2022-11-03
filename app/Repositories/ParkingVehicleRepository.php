<?Php

namespace App\Repositories;

use App\Models\ParkingVehicle;

class ParkingVehicleRepository 
{
    protected $parkingVehicle;

    public function __construct(ParkingVehicle $parkingVehicle)
    {
        $this->parkingVehicle = $parkingVehicle;
    }

    public function findByID($id)
    {
        return $this->parkingVehicle
                    ->find($id);
    }

    public function save($data)
    {
        return $this->parkingVehicle
                    ->create($data);
    }

    public function deleteByID($id)
    {
        return $this->parkingVehicle
                    ->destroy($id);
    }
}