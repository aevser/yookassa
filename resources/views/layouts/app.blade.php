<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="СПИШЕМ 100% ВАШИХ ДОЛГОВ ИЛИ ВЫПЛАТИМ ИХ ЗА ВАС">

    {{--    favicon--}}
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <title>СПИШЕМ 100% ВАШИХ ДОЛГОВ ИЛИ ВЫПЛАТИМ ИХ ЗА ВАС</title>
    @vite([
        'resources/js/app.js',
        'resources/sass/style.scss'
    ])

</head>
<body>

<div id="app">

    <header class="header">
        <div class="cont">
            <div class="header__wrapper">
                <div class="header__logo">
                    <img src="{{ Vite::asset('resources/img/logo.svg') }}" alt="2">
                </div>
                <div class="header__images">
                    <div class="header__image">
                        <img src="{{ Vite::asset('resources/img/logo2.svg') }}" alt="2">
                    </div>
                    <div class="header__image">
                        <img src="{{ Vite::asset('resources/img/logo3.svg') }}" alt="2">
                    </div>
                </div>
                <button class="header__button" data-modal>
                    <img src="{{ Vite::asset('resources/img/phone.svg') }}" alt="phone">
                    <span>Бесплатная консультация</span>
                </button>
            </div>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="cont">
            <div class="footer__wrapper">
                <div class="footer__col">
                    © Все права защищены 2012-2023<br>
                    ООО ЦФЗ "ДОЛЖНИК ПРАВ"<br>
                    ИНН:  7453293238<br>
                    ОГРН:  1167456068735<br>
                    <!-- <a href="mailto:bankrotstvo-rf01@yandex.ru"></a>bankrotstvo-rf01@yandex.ru<br>
                    <a href="tel:89879094157">89879094157</a> -->
                </div>
                <div class="footer__col">
                    <a class="footer__link" href="/policy">Политика конфиденциальности</a>
                    <p>
                        Персональная информация используется<br>
                        внутри компании исключительно для связи по<br>
                        вопросам списания долгов
                    </p>
                </div>
                <div class="footer__col">
                    <b>Юридический адрес</b>
                    <p>           
                        454080, Челябинская область, <br> г.о. Челябинский, вн.р-н Центральный, <br> г. Челябинск, ул Энгельса, д. 43
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <modal-app></modal-app>
</div>

@include('layouts._counters', [
        'counters' => [
            'facebook' =>[],
            'yandexMetrika' => [95967052],
            'mailTarget' => [3418650],
            'mailRu' => [],
            'google' => []
            ]
            ])

</body>
</html>
