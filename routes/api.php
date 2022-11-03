<?php

use App\Http\Controllers\Api\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Util\Test;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('test-bestada')
        ->controller(TestController::class)
        ->group(function()
        {
            Route::prefix('customers')
                    ->group(function()
                    {
                        Route::get('/', 'getCustomer');
                    });
            
            Route::prefix('orders')
                    ->group(function()
                    {
                        Route::post('/', 'getOrder');
                    });

            Route::prefix('bloks')
                    ->group(function()
                    {
                        Route::get('/', 'detailBlok');
                        Route::post('/fill', 'fillBlok');
                        Route::post('/out', 'outBlok');
                    });
            
            Route::get('/point-4/{no}', 'testPoint4');
        });