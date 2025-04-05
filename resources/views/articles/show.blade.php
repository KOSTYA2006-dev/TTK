@extends('layouts.app')

@section('content')
<div class="articles-container">
    <div class="articles-header">
        <h1>{{ $article->title }}</h1>
        <div class="header-actions">
            <a href="{{ route('articles.edit', $article) }}" class="btn-create">
                <i class="fas fa-edit"></i> Редактировать
            </a>
            <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-history" onclick="return confirm('Вы уверены?')">
                    <i class="fas fa-trash"></i> Удалить
                </button>
            </form>
            <a href="{{ route('articles.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Назад к списку
            </a>
        </div>
    </div>

    <div class="article-view">
        @if($article->image)
            <div class="article-image-container">
                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="article-image">
            </div>
        @endif

        <div class="article-content-view">
            {!! $article->content !!}
        </div>

        <div class="article-meta-view">
            <div class="meta-item">
                <i class="fas fa-user"></i>
                {{ $article->user->full_name }}
            </div>
            <div class="meta-item">
                <i class="fas fa-calendar"></i>
                {{ $article->created_at->format('d.m.Y H:i') }}
            </div>
            @if($article->updated_at != $article->created_at)
                <div class="meta-item">
                    <i class="fas fa-edit"></i>
                    Последнее обновление: {{ $article->updated_at->format('d.m.Y H:i') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('assets/css/articles.css') }}" rel="stylesheet">
@endpush 