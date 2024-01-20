<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [

    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function report(Throwable $e)
    {
        if (($e instanceof Throwable) && !($e instanceof NotFoundHttpException)) {
            $domen = array_key_exists( 'HTTP_HOST', $_SERVER) ? $_SERVER['HTTP_HOST'] : 'домен не определен';
            $data = "Ошибка на домене {$domen}  \n {$e->getMessage()}".PHP_EOL;
            $this->send2Telegram('257203518',$data,'1725816868:AAF90XcAtg4taBl1fEBaKKIgdFftJm_VaDE');
        }

        return parent::report($e);
    }

    public function send2Telegram($id, $msg, $token = '', $silent = false) {
        $data = array(
            'chat_id' => $id,
            'text' => $msg,
            'parse_mode' => 'html',
            'disable_web_page_preview' => true,
            'disable_notification' => $silent
        );
        if($token != '') {
            $ch = curl_init('https://api.telegram.org/bot'.$token.'/sendMessage');
            curl_setopt_array($ch, array(
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $data
            ));
            curl_exec($ch);
            curl_close($ch);
        }
    }
}
