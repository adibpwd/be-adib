<?php

namespace Database\Seeders;

use App\Models\Blok;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $city_id = ['bekasi', 'jakarta'];
        $shipment_status = ['waiting', 'sent', 'cancel'];

        for($i = 1; $i <= 50; $i++)
        {
          User::create([
            'id' => $i,
            'name' => 'test ' . $i,
            'email' => 'test ' . $i . '@gmail.com',
            'password' => Hash::make('test-bestada'),
            'phone' => "08{$i}52{$i}{$i}",
            'address' => $city_id[rand(0,1)],
          ]);

          Blok::create([
            'name' => 'blok ' . $i,
            'max_slot' => rand(3, 8)
          ]);

        }

        for ($i=0; $i < 300; $i++) 
        { 
            $datestart = strtotime('2021-11-2');
            $dateend = strtotime('2022-11-2');
            $daystep = 86400;
            $datebetween = abs(($dateend - $datestart) / $daystep);
            $randomday = rand(0, $datebetween);

            $code = rand(1111, 9999);

            $order = Order::create([
                'user_id' => rand(1, 50),
                'code' => $code,
                'resi_number' => rand(1111, 9999) . rand(1111, 9999) . rand(1111, 9999) . rand(1111, 9999)
            ]);

            Shipment::create([
                'order_id' => $order->id,
                'code' => $code,
                'status' => $shipment_status[rand(0,2)],
                'created_at' => date("Y-m-d", $datestart + ($randomday * $daystep))
            ]);
        }
    }
}
