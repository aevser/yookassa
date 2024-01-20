@extends('layouts.app')

@section('content')

    <section class="promo">
        <div class="cont">
            <div class="promo__wrapper">
                <h1 class="promo__title">СПИШЕМ 100% ВАШИХ ДОЛГОВ ИЛИ ВЫПЛАТИМ ИХ ЗА ВАС</h1>
                <div class="promo__subtitle">Результат уже через 30 дней</div>
                <div class="promo__notice">
                    Ответьте на 4 вопроса и получите <br>
                    предложение которое вас устроит
                </div>
                <div class="promo__quiz">
                    <quiz-app></quiz-app>
                </div>
            </div>
        </div>
        <div class="promo__img">
            <img src="{{ Vite::asset('resources/img/promo.png') }}" alt="promo">
        </div>
    </section>

@endsection
