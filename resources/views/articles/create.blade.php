@extends('layouts.app')

@section('content')
<div class="articles-container">
    <div class="articles-header">
        <h1>Создание новой статьи</h1>
        <a href="{{ route('articles.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Назад к списку
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" id="createForm">
        @csrf
        <div class="form-group">
            <label for="title">Название статьи *</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="content">Содержание *</label>
            <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
        </div>

        <div class="form-group">
            <label for="image">Изображение</label>
            <div class="image-upload">
                <input type="file" id="image" name="image" accept="image/*">
                <div class="image-preview">
                    <img src="" alt="Предпросмотр">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Создать статью</button>
            <a href="{{ route('articles.index') }}" class="btn-cancel">Отмена</a>
        </div>
    </form>
</div>
@endsection

@push('styles')
<link href="{{ asset('assets/css/articles.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script>

    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.querySelector('.image-preview');
                const img = preview.querySelector('img');
                img.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });


    document.getElementById('createForm').addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Form submitted');
        
        const content = document.getElementById('content').value;
        if (!content.trim()) {
            alert('Пожалуйста, введите содержание статьи');
            return;
        }
        

        const formData = new FormData(this);
        

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                window.location.href = "{{ route('articles.index') }}";
            } else {
                alert(data.message || 'Произошла ошибка при создании статьи');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка при создании статьи');
        });
    });
</script>
@endpush 