<?php

use App\Http\Controllers\Api\V1\CreateOrderController;
use App\Http\Controllers\Api\V2\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->name('v1.')->group(function(){
    Route::post('lead.add', CreateOrderController::class)->name('lead.add');

    Route::get('counters', function (){
        return response()->json([
            'ym'=>95967052,
            'fbq'=>'',
            //'mailRu' => ['id' => 3268254, 'goal' => 'contact']
        ],200);
    });
});

