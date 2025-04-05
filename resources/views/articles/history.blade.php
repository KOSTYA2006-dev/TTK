@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>История изменений статей</h2>
                    <a href="{{ route('articles.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Назад к статьям
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Действие</th>
                                    <th>Статья</th>
                                    <th>Пользователь</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($histories as $history)
                                    <tr>
                                        <td>{{ $history->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            @switch($history->event_type)
                                                @case('created')
                                                    <span class="badge bg-success">Создана</span>
                                                    @break
                                                @case('updated')
                                                    <span class="badge bg-primary">Обновлена</span>
                                                    @break
                                                @case('deleted')
                                                    <span class="badge bg-danger">Удалена</span>
                                                    @break
                                                @case('restored')
                                                    <span class="badge bg-warning">Восстановлена</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($history->article)
                                                {{ $history->article->title }}
                                            @else
                                                <span class="text-muted">Статья удалена</span>
                                            @endif
                                        </td>
                                        <td>{{ $history->user->full_name }}</td>
                                        <td>
                                            @if($history->event_type === 'deleted' && $history->article && $history->article->trashed() && $history->created_at->gt(now()->subWeek()))
                                                <form action="{{ route('articles.restore', $history->article->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Вы уверены, что хотите восстановить эту статью?')">
                                                        <i class="fas fa-undo"></i> Восстановить
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">История изменений пуста</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $histories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('assets/css/articles.css') }}" rel="stylesheet">
<style>
.table th {
    background-color: #f8f9fa;
}
.badge {
    font-size: 0.9em;
    padding: 0.5em 0.8em;
}
.btn-warning {
    color: #fff;
}
</style>
@endpush
