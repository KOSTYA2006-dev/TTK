@extends('layouts.app')

@section('content')
<main class="main">
    <div class="container">
        <div class="main__content">
            <div class="text-container">
                <h1 class="main__content__title">
                    <span class="animation">веб-органайзер</span>
                    <span class="animation"><br>для офиса</span>
                </h1>
                <p class="main__content__text">
                Устали от хаоса в рабочих процессах? Наш офисный веб-органайзер – это современное решение для команд и отдельных сотрудников, которое помогает структурировать информацию, управлять задачами и повышать продуктивность.
                </p>

                @auth
                    <button class="learn-more">
                        <a href="">
                            <span class="circle" aria-hidden="true">
                                <span class="icon arrow"></span>
                            </span>
                            <span class="button-text">смотреть задачи</span>
                        </a>
                    </button>
                @else
                    <button class="learn-more">
                        <span class="circle" aria-hidden="true">
                            <span class="icon arrow"></span>
                        </span>
                        <span class="button-text">смотреть задачи</span>
                    </button>
                @endauth
            </div>
            <div class="pic-container">
                <div class="slider-container">
                    <div class="slider">
                        <div class="slide active">
                            <img src="assets/img/ttk.jpg" alt="ttk" style="">
                            <div class="slide-text">
                                <h2>ТТК</h2>
                                <p>Откройте для себя веб-органайзер</p>
                            </div>
                        </div>
                        <div class="slide">
                            <img src="assets/img/ttk.jpg" alt="Город">
                            <div class="slide-text">
                                <h2>Задачи</h2>
                                <p>Новый мощный ТаскТрекер</p>
                            </div>
                        </div>
                        <div class="slide">
                            <img src="assets/img/ttk.jpg" alt="Пляж">
                            <div class="slide-text">
                                <h2>ТТК статьи</h2>
                                <p>Создай свою статью</p>
                            </div>
                        </div>
                    </div>

                    <button class="prev">❮</button>
                    <button class="next">❯</button>

                    <div class="dots-container">
                        <span class="dot active"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="items-wrap">
        <div class="items marquee">
            <p class="item">TTK</p>
            <p class="item">ЛУЧШИЙ</p>
            <p class="item">Задачи</p>
            <p class="item">Статьи</p>
        </div>
        <div aria-hidden="true" class="items marquee">
            <p class="item">TTK</p>
            <p class="item">ЛУЧШИЙ</p>
            <p class="item">Задачи</p>
            <p class="item">Статьи</p>
        </div>
    </div>
</main>

<section class="about-block">
    <div class="container">
        <div class="about-block__content">
            <div class="about-block__content__info">
                <h2>О нас</h2>
                <p class="about-block__content__info__text">
                    Мы – команда профессионалов, которые понимают, насколько важна эффективная организация работы в современном офисе. Наша цель – создавать удобные и функциональные инструменты, помогающие бизнесу работать слаженно и без лишних затрат времени.
                </p>
                <p class="about-block__content__info__text">
                    Почему стоит выбрать нас?
                    🔹 Опыт – мы знаем, какие решения действительно упрощают рабочие процессы.
                    🔹 Инновации – постоянно развиваем продукт, добавляя новые полезные функции.
                    🔹 Поддержка – всегда готовы помочь с внедрением и ответить на ваши вопросы.

                    Присоединяйтесь к тем, кто уже сделал работу проще и эффективнее! 🚀
                </p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/main/main-set.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/main/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/main/about-block.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/main/modal-auth.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/main/slider.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/main/footer.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
@endpush

@push('scripts')
<script src="assets/js/modal-menu.js"></script>
<script src="assets/js/modal-auth.js"></script>
<script src="assets/js/slider.js"></script>
@endpush

