<?Php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository 
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getFilterByCityOrStatusOrMinOrMaxDate($city, $status, $min_date, $max_date)
    {
        return $this->order
                    ->whereHas('shipment', function($q) use($min_date, $max_date, $status)
                    {
                        if ( $status != null )
                        {
                            $q->whereIn('status', $status);
                        }
                        
                        if ( $min_date != null && $max_date != null )
                        {
                            $q->whereBetween('created_at', [$min_date, $max_date]);
                        }

                        return $q;
                    })
                    ->whereHas('customer', function($q) use ($city)
                    {
                        if ( $city != null )
                        {
                            $q->where('address', 'LIKE', "%{$city}%");
                        }

                        return $q;
                    })->with(['shipment','customer:id,name,phone,address'])->get();
    }
}