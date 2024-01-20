<?php

namespace App\Services;

use App\Http\Requests\Api\V1\Order\CreateRequest;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderService{
    public const PER_PAGE = 10;


    /**
     *      CUD-методы
     */

    public function create(string $name, string $phone): Order
    {
        $status = Order::STATUS_FIRST;
        $previousOrders = $this->findByPhone($phone);

        if($previousOrders->isNotEmpty())
        {
            $status = Order::STATUS_NEW;
            $this->query()->where(['phone' => $phone])
                ->where('status', '!=', Order::STATUS_FIRST)
                ->lazyById(chunkSize: 500, column: 'id')
                ->each->update(['status' => Order::STATUS_REPEAT]);
        }

        return Order::create(['name' => $name, 'phone' => $phone, 'status' => $status]);
    } //create

    public function update(Order|int $order, string $status): Order
    {
        if(is_int($order))
            $order = $this->findById(id: $order, fail: true);

        $order->update(['status' => $status]);

        return $order;
    } //update

    public function remove(Order|int $order): void
    {
        if(is_numeric($order))
            $this->query()->where('id', $order)->delete();
        elseif($order instanceof Order)
            $order->delete();
    } //remove

    /**
     *      R-Методы
     */
    public function query(): Builder
    {
        return Order::query()->filters();
    } //query

    public function findById(int $id, bool $fail = false): ?Order
    {
        $query = $this->query()->where('id', $id);
        return $fail ? $query->firstOrFail() : $query->first();
    } //findById

    public function findByPhone(string $phone): Collection
    {
        return $this->query()->where('phone', $phone)->get();
    } //findByName

    /**
     *      Методы для экранов Orchid и контроллеров
     */
    public function orderList(bool $unique = false): LengthAwarePaginator //
    {
        return $this->query()->defaultSort('created_at', 'desc')
        ->when(value: $unique, callback: function($query){
            return $query->new();
        })
        ->latest()
        ->paginate(self::PER_PAGE);
    } //orderList

    public function leadAdd(CreateRequest $request): Order
    {
        return $this->create(name: $request->name, phone: $request->phone);
    } //leadAdd

    /**
     *      Другие методы
     */
    public function resetStatuses(): void //Вернуть всем лидам статус на new
    {
        $this->query()->where(column: 'status', operator: '!=', value: Order::STATUS_NEW)
            ->lazyById()
            ->each->update(['status' => Order::STATUS_NEW]);
    } //makeAllNew


    public function leadHunterAdd(CreateRequest $request, string $token): void
    {
        $data = [
            'api_token' => $token,
            'name' =>$request->has('name') ? $request->input('name') : 'Аноним',
            'phone' => $request->input('phone'),
            'city' => $request->input('city'),
            'cost' => $request->input('cost'),
            'comment' => $request->has('data') ? $request->input('data') : '',
            'ip' => $this->getUserIpAddr(),
            'host' => $request->input('host'),
            'referrer' => $request->input('referrer'),
            'url_query_string' => $request->input('url_query_string')
        ];

        $response = Http::withOptions(['verify' => false])->post('https://in.leads-hunter.com/api/v1/lead.add', $data);

        Log::info($response);
    }

    public function getUserIpAddr(){
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        return $ipaddress;
    }
};

?>
