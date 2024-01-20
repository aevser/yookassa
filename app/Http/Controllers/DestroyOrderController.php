<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;

// use Illuminate\Http\Request;

class DestroyOrderController extends Controller
{
    public function __construct(
        private OrderService $service
    )
    {
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
    }

    /**
     * Handle the incoming request.
     *
     * @param  Order|int  $order
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Order|int $order)
    {
        $this->service->remove($order);
        return back();
    }
}
