@extends('layouts.app')

@section('content')

    <main>

        <section class="thanks">

            <a class="thanks__close" href="/">
                <img src="{{ Vite::asset('resources/img/close.svg') }}" alt="close">
            </a>

            <div class="thanks__container">
                <h1 class="thanks__title">Спасибо за вашу заявку!</h1>
                <h2 class="thanks__text">Наш менеджер скоро с вами свяжется</h2>
            </div>

        </section>
        <!-- /.thanks -->

    </main>

@endsection
