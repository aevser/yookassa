<?php

use App\Http\Controllers\DestroyOrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('main');
})->name('home');
Route::get('/thanks', function () {
    return view('thanks');
})->name('thanks');
Route::get('/politics', function () {
    return view('politics');
})->name('politics');

Route::middleware(['auth'])->group(function(){
    Route::get('admin/orders/delete/{order}', DestroyOrderController::class)->name('order.destroy');
});

Route::match(['GET', 'POST'], '/payments/callback', [PaymentController::class, 'callback'])
    ->name('payment.callback');
Route::post('/payments/create', [PaymentController::class, 'create'])
    ->name('payment.create');
Route::get('/payment', [PaymentController::class, 'index'])
    ->name('payment.index');

//Route::fallback(function () {
//   return redirect('/');
//});
