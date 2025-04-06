@extends('layouts.app')

@section('content')
<div class="profile-container">
    <div class="profile-card">
        <div class="profile-image-container">
            <div class="profile-image" id="profileImage" style="background-image: url('{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}')">
                <div class="upload-overlay">
                    <label for="imageUpload" class="upload-button">Изменить фото</label>
                    <input type="file" id="imageUpload" accept="image/*" style="display: none;">
                </div>
            </div>
        </div>
        <div class="profile-info">
            <div class="info-item">
                <span class="label">Имя:</span>
                <span class="value">{{ $user->full_name }}</span>
            </div>
            <div class="info-item">
                <span class="label">Login:</span>
                <span class="value">{{ $user->login }}</span>
            </div>
            <div class="info-item">
                <div class="d-flex gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        Редактировать профиль
                    </a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.users.index') }}" class="btn btn-warning">
                            <i class="fas fa-cog"></i> Админ панель
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt"></i> Выйти
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="viewed-articles">
        <h2>Последние изменения</h2>
        <div class="articles-list">
            <div class="block">
                <div class="img_container">
                    <p class="date">{{ now()->format('d.m.Y') }}</p>
                    <img class='image' src="{{ asset('images/default-avatar.png') }}" alt="Profile Image">
                </div>
                <h3>Профиль пользователя</h3>
                <h5>Вносил недавние изменения:</h5>
                <p>{{ $user->full_name }}</p>
                <p>{{ $user->email }}</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        background-color: #ffffff;
    }

    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .profile-card {
        background-color: #ffffff;
        border-radius: 0;
        padding: 20px;
        display: flex;
        margin-bottom: 30px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border: 1px solid #f0f0f0;
    }

    .profile-image-container {
        position: relative;
        width: 300px;
        height: 400px;
        margin-right: 30px;
        flex-shrink: 0;
    }

    .profile-image {
        width: 100%;
        height: 100%;
        border-radius: 0;
        position: relative;
        overflow: hidden;
        background-size: cover;
        background-position: center;
    }

    .upload-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.7);
        padding: 10px;
        text-align: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .profile-image:hover .upload-overlay {
        opacity: 1;
    }

    .upload-button {
        color: white;
        cursor: pointer;
        font-size: 14px;
        padding: 8px 16px;
        background-color: #ff0000;
        border-radius: 0;
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .upload-button:hover {
        background-color: #e60000;
    }

    .profile-info {
        flex-grow: 1;
    }

    .info-item {
        margin-bottom: 20px;
        font-size: 26px;
    }

    .label {
        font-weight: bold;
        margin-right: 10px;
        color: #070000;
    }

    .value {
        color: #333;
    }

    .viewed-articles {
        background-color: #ffffff;
        border-radius: 0;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border: 1px solid #f0f0f0;
    }

    .viewed-articles h2 {
        margin-bottom: 5px;
        color: #000000;
        text-align: center;
        font-size: 30px;
    }

    .articles-list {
        min-height: 100px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 20px 0;
    }

    .block {
        background-color: #ffffff;
        width: 100%;
        height: auto;
        margin: 0;
        transition: all 0.3s ease;
        text-decoration: none;
        border-radius: 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border: 1px solid #f0f0f0;
        padding: 15px;
        overflow: hidden;
    }

    .block p {
        font-size: 14px;
        margin: 8px 0;
        color: #666;
        word-wrap: break-word;
    }

    .block h5 {
        font-size: 14px;
        margin: 12px 0 8px 0;
        color: #ff0000;
        word-wrap: break-word;
    }

    .block h3 {
        font-size: 18px;
        margin: 12px 0;
        color: #333;
        word-wrap: break-word;
    }

    .image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 0;
        display: block;
    }

    .img_container {
        position: relative;
        margin-bottom: 15px;
    }

    .date {
        background-color: #ffffff;
        color: #030000;
        padding: 6px 12px;
        border-radius: 0;
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 12px;
        font-weight: 600;
        z-index: 1;
    }

    .block:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(255, 0, 0, 0.1);
        border-color: #ff0000;
    }

    @media (max-width: 768px) {
        .articles-list {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageUpload = document.getElementById('imageUpload');
    const profileImage = document.getElementById('profileImage');

    // Загружаем сохраненное изображение при загрузке страницы
    const savedImage = localStorage.getItem('profileImage');
    if (savedImage) {
        profileImage.style.backgroundImage = `url(${savedImage})`;
    }

    imageUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const imageData = event.target.result;
                // Сохраняем изображение в localStorage
                localStorage.setItem('profileImage', imageData);
                // Отображаем изображение
                profileImage.style.backgroundImage = `url(${imageData})`;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
@endsection
