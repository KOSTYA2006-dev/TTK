@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>Статьи</h2>
                    <div>
                        <a href="{{ route('articles.history') }}" class="btn btn-info me-2">
                            <i class="fas fa-history"></i> История изменений
                        </a>
                        <a href="{{ route('articles.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Создать статью
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="articles-grid">
                        @forelse($articles as $article)
                            <div class="article-card">
                                @if($article->image)
                                    <div class="article-image-container">
                                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="article-image">
                                    </div>
                                @endif
                                <div class="article-content">
                                    <h3>{{ $article->title }}</h3>
                                    <div class="article-meta">
                                        <div class="meta-item">
                                            <i class="fas fa-user"></i>
                                            {{ $article->user->full_name }}
                                        </div>
                                        <div class="meta-item">
                                            <i class="fas fa-calendar"></i>
                                            {{ $article->created_at->format('d.m.Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="article-actions">
                                        <a href="{{ route('articles.show', $article) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> Просмотр
                                        </a>
                                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Редактировать
                                        </a>
                                        <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')">
                                                <i class="fas fa-trash"></i> Удалить
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="no-articles">
                                <p>Статьи не найдены</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('assets/css/articles.css') }}" rel="stylesheet">
@endpush




