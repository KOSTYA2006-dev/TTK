<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>История изменений | TravelBuddy</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/articles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

@include('header.header')

<main class="history-container">
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="history-header">
        <h1>История изменений статей</h1>
        <a href="/stati" class="btn-back">
            <i class="fas fa-arrow-left"></i> Назад к статьям
        </a>
    </div>

    <div class="history-table-container">
        <table class="history-table">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Пользователь</th>
                    <th>Статья</th>
                    <th>Событие</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $history)
                    <tr>
                        <td>{{ $history->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $history->user->full_name }}</td>
                        <td>
                            @if($history->article)
                                {{ $history->article->title }}
                            @else
                                <span class="deleted-article">Удаленная статья</span>
                            @endif
                        </td>
                        <td>
                            <span class="event-badge {{ $history->event_type }}">
                                @switch($history->event_type)
                                    @case('created')
                                        Создание
                                        @break
                                    @case('updated')
                                        Редактирование
                                        @break
                                    @case('deleted')
                                        Удаление
                                        @break
                                    @case('restored')
                                        Восстановление
                                        @break
                                @endswitch
                            </span>
                        </td>
                        <td>
                            @if($history->event_type === 'deleted' && $history->created_at->gt(now()->subWeek()))
                                @can('restore', App\Models\Article::class)
                                    <button class="btn-restore" onclick="restoreArticle({{ $history->article_id }})">
                                        <i class="fas fa-undo"></i> Восстановить
                                    </button>
                                @endcan
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="no-records">
                            <p>История изменений пуста</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container">
        {{ $histories->links() }}
    </div>
</main>

<script>
    async function restoreArticle(articleId) {
        if (!confirm('Вы уверены, что хотите восстановить эту статью?')) {
            return;
        }

        try {
            const response = await fetch(`/stati/${articleId}/restore`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Ошибка сервера');
            }

            if (data.success) {
                window.location.reload();
            } else {
                showError(data.message || 'Ошибка при восстановлении статьи');
            }
        } catch (error) {
            console.error('Error:', error);
            showError(error.message);
        }
    }

    function showError(message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger';
        alertDiv.textContent = message;
        
        const container = document.querySelector('.history-container');
        container.insertBefore(alertDiv, container.firstChild);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
</script>

</body>
</html> 