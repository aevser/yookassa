<?php

namespace App\Services;

use Illuminate\Http\Request;
use YooKassa\Client;

class PaymentService
{
    public function getClient(): Client
    {
        $client = new Client();
        $client->setAuth(env('YOOKASSA_SHOP_ID'), env('YOOKASSA_SECRET_KEY'));

        return $client;
    }

    public function createPayment(float $amount, array $options = [])
    {
        $client = $this->getClient();
        $payment = $client->createPayment([
            'amount' => [
                'value' => $amount,
                'currency' => 'RUB'
            ],
            'capture' => true,
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => route('payment.index')
            ],
            'metadata' => [
                'transaction_id' => $options['transaction_id']
            ],

        ], uniqid('', true));

        return $payment->getConfirmation()->getConfirmationUrl();
    }
}