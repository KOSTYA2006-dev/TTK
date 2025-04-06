

<link rel="stylesheet" href="{{ asset('assets/css/game.css') }}">
@extends('layouts.app')

@section('content')

    <div class="start-screen">
        <h1>Flappy Bird</h1>
        <p>Собери 33 монетки или пролети 33 трубы!</p>
        <button id="start-game">Начать игру</button>
    </div>
    <div class="content-game">
        <div class="game-container hidden">
            <div class="sky">
                <div class="clouds">
                <div class="cloud cloud1"></div>
                <div class="cloud cloud2"></div>
                <div class="cloud cloud3"></div>
            </div>
        </div>
        <div class="bird"></div>
        <div class="score-container">
            <div class="score">Трубы: <span id="pipes-count">0</span>/33</div>
            <div class="coins">Монетки: <span id="coins-count">0</span>/33</div>
        </div>
        <div class="game-over hidden">
            <h2>Игра окончена!</h2>
            <button id="restart">Начать заново</button>
        </div>
    </div>
    <script src="{{ asset('assets/js/game.js') }}"></script>
@endsection 