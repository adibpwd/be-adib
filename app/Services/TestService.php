<?Php

namespace App\Services;

use App\Http\Library\ApiHelper;
use App\Repositories\BlokRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ParkingVehicleRepository;
use App\Repositories\ShipmentRepository;
use App\Repositories\UserRepository;

class TestService
{
    use ApiHelper;

    protected $userRepository;
    protected $orderRepository;
    protected $blokRepository;
    protected $parkingVehicleRepository;

    public function __construct(
        UserRepository $userRepository, 
        OrderRepository $orderRepository, 
        BlokRepository $blokRepository, 
        ParkingVehicleRepository $parkingVehicleRepository, 
    )
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->blokRepository = $blokRepository;
        $this->parkingVehicleRepository = $parkingVehicleRepository;
    }

    public function getCustomerDetail($data)
    {
        try 
        {
            $customers = $this->userRepository->getByCity($data['city']);

            if ( count($customers) == 0 ) return $this->onError(404, ["do not match our record"], "Failed to get customers");

            return $this->onSuccess(200, $customers, "Successfully to get customers");
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return $this->onError(500, ['Report to admin please'], 'Failed to get customers');
        }
    }

    public function getOrderFilter($city, $status, $min_date, $max_date)
    {
        try 
        {
            $orders = $this->orderRepository->getFilterByCityOrStatusOrMinOrMaxDate($city, $status, $min_date, $max_date);
            
            if ( count($orders) == 0 ) return $this->onError(404, ["do not match our record"], "Failed to get orders");
            
            return $this->onSuccess(200, $orders, "Successfully to get orders");
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return $this->onError(500, ['Report to admin please'], 'Failed to get orders');
        }
    }

    public function getDetailBlok($name)
    {
        try 
        {
            $blok = $this->blokRepository->getDetailSlotBlokByName($name);

            if ( $blok == null ) return $this->onError(404, ["Do not match our record"], "Failed to get detail blok");

            return $this->onSuccess(200, $blok, "Successfully to get detail blok");
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return $this->onError(500, ['Report to admin please'], 'Failed to get detail blok');
        }
    }

    public function fillVehicleToBlok($data)
    {
        try 
        {
            $blok = $this->blokRepository->findByIDWithParkingVehicle($data['blok_id']);

            if ( $blok == null ) return $this->onError(404, ["Failed to get detail blok"], "Failed to fill blok");

            if ( $blok['parking_vehicle_count'] > $blok['max_slot'] ) return $this->onError(400, ["Slot full"], "Failed to fill blok");

            $parking_vehicle = $this->parkingVehicleRepository->save($data);

            return $this->onSuccess(200, $parking_vehicle, "Successfully to fill blok");
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return $this->onError(500, ['Report to admin please'], 'Failed to fill blok');
        }
    }

    public function outVehicleFromBlok($id)
    {
        try 
        {
            $parking_vehicle = $this->parkingVehicleRepository->findByID($id);

            if ( $parking_vehicle == null ) return $this->onError(404, ["Failed to get parking vehicle"], "Failed to out vehicle from blok");
            
            $this->parkingVehicleRepository->deleteByID($id);
            
            return $this->onSuccess(200, null, "Successfully to out vehicle from blok");
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return $this->onError(500, ['Report to admin please'], 'Failed to out vehicle from blok');
        }
    }
}