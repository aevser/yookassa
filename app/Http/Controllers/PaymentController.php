<?php

namespace App\Http\Controllers;

use App\Emun\PaymentStatusEnum;
use App\Mail\PaymentEmail;
use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use YooKassa\Model\Notification\NotificationEventType;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\Payment\PaymentStatus;

class PaymentController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('id')->get();

        return view('payment', [
            'transactions' => $transactions
        ]);
    }

    public function create(Request $request, PaymentService $service)
    {
        $amount = (float)$request->input('amount');

        $transaction = Transaction::create([
            'amount' => $amount
        ]);

        if($transaction){
            $link = $service->createPayment($amount, [
                'transaction_id' => $transaction->id,
            ]);

            return redirect()->away($link);
        }   
    }

    public function callback(Request $request, PaymentService $service)
    {
        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);

        $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
            ? new NotificationSucceeded($requestBody)
            : new NotificationWaitingForCapture($requestBody);

        $payment = $notification->getObject();

        if(isset($payment->status) && $payment->status === 'pending'){
            $service->getClient()->capturePayment([
                'amount' => $payment->amount,
            ], $payment->id, uniqid('', true));
        }

        if(isset($payment->status) && $payment->status === 'SUCCEEDED'){
            if((bool)$payment->paid === true){
                $metadata = (object)$payment->metadata;
                if(isset($metadata->transaction_id)){
                    $transactionId = (int)$metadata->transaction_id;
                    $transaction = Transaction::find($transactionId);
                    $transaction->status = PaymentStatusEnum::CONFIRMED;
                    $transaction->save();

                    Mail::to('llaravel@yandex.ru')->send(new PaymentEmail());

                    if(cache()->has('amount')){
                        cache()->forever('balance', (float)cache()->get('balance', + (float)$payment->amount->value));
                    }else{
                        cache()->forever('balance', (float)$payment->amount->value);
                    }
                }
            }
        }
    }
}
