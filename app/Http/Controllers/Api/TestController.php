<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelper;
use App\Http\Library\Validation\TestValidationRules;
use App\Models\Order;
use App\Services\TestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    use ApiHelper, TestValidationRules;

    protected $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    /**
     * @OA\Get(
     *      path="/api/test-bestada/customers",
     *      operationId="getCustomer",
     *      tags={"Point-1"},
     *      summary="Get Customer By City",
     *      description="Task : Buatlah query untuk menampilkan semua customer yang berasal dari kota Jakarta</br></br>Saya simpel in, jadi ambil daftar customer dari kotanya",
     *      @OA\Parameter(
     *          name="city",
     *          description="City From Customer",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully to get customer"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="array",
     *                     @OA\Items(
     *                        @OA\Property(
     *                               property="id",
     *                               type="integer",
     *                               example="3"
     *                        ),
     *                        @OA\Property(
     *                               property="name",
     *                               type="string",
     *                               example="test 3"
     *                        ),
     *                        @OA\Property(
     *                               property="email",
     *                               type="string",
     *                               example="test 3@gmail.com"
     *                        ),
     *                        @OA\Property(
     *                               property="email_verified_at",
     *                               type="string",
     *                               example=null
     *                        ),
     *                        @OA\Property(
     *                               property="phone",
     *                               type="string",
     *                               example="082229229123"
     *                        ),
     *                        @OA\Property(
     *                               property="address",
     *                               type="string",
     *                               example="bekasi"
     *                        ),
     *                        @OA\Property(
     *                               property="created_at",
     *                               type="string",
     *                               example="2022-11-02T14:15:08.000000Z"
     *                        ),
     *                        @OA\Property(
     *                               property="updated_at",
     *                               type="string",
     *                               example="2022-11-02T14:15:08.000000Z"
     *                        ),
     *                     )
     *                 ),
     *             )
     *          )
     *       ),
     *     )
    */
    public function getCustomer()
    {
        $all_req = request()->all();
        
        $validator = Validator::make(
            $all_req, 
            $this->getCustomerRules()
        );
        
        if ($validator->fails()) 
        {
            return $this->onError(400, $validator->errors()->toArray(), "error validations");
        }

        return $this->testService->getCustomerDetail($all_req);
    }

    /**
     * @OA\Post(
     *      path="/api/test-bestada/orders",
     *      operationId="getOrder",
     *      tags={"Point-1"},
     *      summary="Get Order Filter By City, Status[], Min/Max Date",
     *      description="Task : <br>Buatlah query untuk menampilkan semua informasi pembelian yang sudah terkirim dari seluruh customer (mencangkup seluruh informasi pada ketiga table dan harus readable)
     *                      </br>Buatlah query untuk menampilkan jumlah pengiriman gagal dan pengiriman berhasil semua customer yang berasal dari kota Bekasi dari bulan Januari 2022 sampai bulan April 2022..
     *                      </br></br>Saya buat 2 task tersebut menjadi 1 endpoint, di filter berdasarkan kota, status ( bisa lebih dari 1 statusya ) dan min atau max date",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="city",
     *    					type="string",
     *    					description="City"
     *                  ),
     *                  @OA\Property(
     *                      property="status",
     *    					type="array",
     *    					description="Status",
     *                      @OA\Items(
     *                          type="string",
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="min_date",
     *    					type="string",
     *    					description="Min Date",
     *                      example="2022-01-01"
     *                  ),
     *                  @OA\Property(
     *                      property="max_date",
     *    					type="string",
     *    					description="Max Date"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully to get orders"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      example={
     *                          "id": 3,
     *                          "user_id": "21",
     *                          "code": "8292",
     *                          "resi_number": "9358854874075849",
     *                          "created_at": "2022-11-02T14:38:53.000000Z",
     *                          "updated_at": "2022-11-02T14:15:08.000000Z",
     *                          "shipment": {
     *                              "id": 1,
     *                              "order_id": 1,
     *                              "code": "8883",
     *                              "status": "sent",
     *                              "created_at": "2022-04-02T00:00:00.000000Z",
     *                              "updated_at": "2022-11-02T14:38:53.000000Z"
     *                          },
     *                              "customer": {
     *                              "id": 21,
     *                              "name": "test 21",
     *                              "phone": "0821522121",
     *                              "address": "jakarta"
     *                          }
     *                     }
     *                  ),
     *             )
     *          )
     *       ),
     *     )
    */
    public function getOrder(Request $request)
    {
        $validator = Validator::make(
            $request->all(), 
            $this->getOrderRules()
        );
        
        if ($validator->fails()) 
        {
            return $this->onError(400, $validator->errors()->toArray(), "error validations");
        }
        return $this->testService->getOrderFilter(
            $request->city ?? null,
            $request->status ?? null,
            $request->min_date ?? null,
            $request->max_date ?? null
        );
    }

    /**
     * @OA\Get(
     *      path="/api/test-bestada/bloks",
     *      operationId="getDetailBlok",
     *      tags={"Point-2&3"},
     *      summary="Get Detail Blok",
     *      description="Task : <br>API untuk mengecek ketersediaan blok dan slot
     *                          </br></br>Saya buat endpoint detail blok, dimana menampilkan max slot dan jumlah ter isi",
     *      @OA\Parameter(
     *          name="name",
     *          description="Name Blok",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully to get detail blok"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      example={
     *                          "id": 1,
     *                          "name": "blok 1",
     *                          "max_slot": 4,
     *                          "created_at": "2022-11-02T16:40:41.000000Z",
     *                          "updated_at": "2022-11-02T16:40:41.000000Z",
     *                          "parking_vehicle_count": 1
     *                       }
     *                  ),
     *             )
     *          )
     *       ),
     *     )
    */
    public function detailBlok()
    {
        $all_req = request()->all();
        
        $validator = Validator::make(
            $all_req, 
            $this->getDetailBlokRules()
        );
        
        if ($validator->fails()) 
        {
            return $this->onError(400, $validator->errors()->toArray(), "error validations");
        }

        return $this->testService->getDetailBlok($all_req['name'] ?? null);
    }

    /**
     * @OA\Post(
     *      path="/api/test-bestada/bloks/fill",
     *      operationId="fillBlok",
     *      tags={"Point-2&3"},
     *      summary="Fill Slot Blok",
     *      description="Task : <br>API untuk kendaraan parkir (mengisi slot parkir pada blok tertentu)
     *                          </br></br>Saya buat menggunakan nama plat kendaraan dan blok_id",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="blok_id",
     *    					type="integer",
     *                      example=1,
     *    					description="Blok ID"
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *    					type="string",
     *    					description="Name Vehicle",
     *                      example="H 9090 HD"
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully to fill blok"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      example={
     *                          "blok_id": "3",
     *                          "name": "H 9090 HD",
     *                          "updated_at": "2022-11-02T17:16:07.000000Z",
     *                          "created_at": "2022-11-02T17:16:07.000000Z",
     *                          "id": 6
     *                      }
     *                  ),
     *             )
     *          )
     *       ),
     *     )
    */
    public function fillBlok(Request $request)
    {
        $validator = Validator::make(
            $request->all(), 
            $this->getOrderRules()
        );
        
        if ($validator->fails()) return $this->onError(400, $validator->errors()->toArray(), "error validations");
        
        return $this->testService->fillVehicleToBlok($request->only(['blok_id', 'name']));
    }

    /**
     * @OA\Post(
     *      path="/api/test-bestada/bloks/out",
     *      operationId="outFromBlok",
     *      tags={"Point-2&3"},
     *      summary="Out Slot From Blok",
     *      description="Task : <br>API untuk kendaraan parkir keluar
     *                          </br></br>Saya buat menggunakan id vehicle nya untuk menghapus dari blok",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="id",
     *    					type="integer",
     *                      example=1,
     *    					description="ID"
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully to out vehicle from blok"),
     *             @OA\Property(
     *                 property="data",
     *                 type="string",
     *                  example=null
     *             )
     *          )
     *       ),
     *     )
    */
    public function outBlok(Request $request)
    {
        $validator = Validator::make(
            $request->all(), 
            $this->outBlokRules()
        );
        
        if ($validator->fails()) 
        {
            return $this->onError(400, $validator->errors()->toArray(), "error validations");
        }

        return $this->testService->outVehicleFromBlok($request->id ?? 0);
    }

    /**
     * @OA\Get(
     *      path="/api/test-bestada/point-4/{no}",
     *      operationId="TestPoint4",
     *      tags={"Point-4"},
     *      summary="Test Point 4",
     *      description="Task : <br>1. Buatlah program untuk melakukan pengecekan apakah suatu bilangan adalah kelipatan dari 7, jika benar maka cetak “bestada” tanpa tanda kutip dan jika bukan maka cetak bilangannya dan disetiap akhir batas bilangan yang dicek maka cetak “sukses” tanpa tanda kutip. Misal:-> Input: range 15, output: 1,2,3,4,5,6,bestada,8,9,10,11,12,13,bestada,sukses.
     *                          </br>2. Buatlah program untuk mengecek nilai yang sama pada array dibawah ini lalu susun arraynya dari yang terbesar ke yang terkecil:-> [3,7,1,2,6,7,8,9,12,5,3,12]
     *                          </br></br>Saya jadikan 1 result",
     *      @OA\Parameter(
     *          name="no",
     *          description="Nomor Maksimal loop task nomor 1 di Point 4",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="string",
     *                 example={
     *                      "1,2,3,4,5,6,bestada,8,9,10,11,12,13,bestada,sukses",
     *                      "12,9,8,7,6,5,3,2,1"
     *                 }
     *             )
     *          )
     *       ),
     *     )
    */
    public function testPoint4($no)
    {
        $result1 = [];

        for ($i=1; $i <= $no; $i++) 
        { 
            if ( $i == $no )
            {
                array_push($result1, 'sukses');
                continue;
            }

            if ( $i % 7 == 0 )
            {
                array_push($result1, 'bestada');   
                continue; 
            }
            
            array_push($result1, $i);
        }

        $check_number = [3,7,1,2,6,7,8,9,12,5,3,12];

        $result2 = array_unique($check_number);

        usort($result2, function ($a, $b) {
            return $a < $b ? 1 : ($a === $b ? 0 : -1);
        });
        
        return [
            "data" => [
                join(',', $result1),
                join(',', $result2)
            ]
        ];
    }
}