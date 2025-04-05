<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Полезная информация | TravelBuddy</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/articles.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

@include('header.header')

<main class="articles-container">
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

    <div class="articles-header">
        <h1>Полезная информация</h1>
        @can('create', App\Models\Article::class)
            <button class="btn-create" onclick="showModal('createArticleModal')">
                <i class="fas fa-plus"></i> Создать статью
            </button>
        @endcan
        <a href="/stati/history/list" class="btn-history">
            <i class="fas fa-history"></i> История изменений
        </a>
    </div>

    <div class="articles-grid">
        @forelse($articles as $article)
            <div class="article-card">
                @if($article->image)
                    <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="article-image">
                @endif
                <div class="article-content">
                    <h3>{{ $article->title }}</h3>
                    <div class="article-meta">
                        <span><i class="fas fa-calendar-alt"></i> {{ $article->created_at->format('d.m.Y') }}</span>
                        <span><i class="fas fa-user"></i> {{ $article->user->full_name }}</span>
                    </div>
                    <div class="article-actions">
                        <button class="btn-view" onclick="showArticle({{ $article->id }})">
                            <i class="fas fa-eye"></i> Просмотр
                        </button>
                        @can('update', $article)
                            <div class="dropdown">
                                <button class="btn-more"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="dropdown-content">
                                    <a href="#" onclick="editArticle({{ $article->id }})"><i class="fas fa-edit"></i> Редактировать</a>
                                    @can('delete', $article)
                                        <a href="#" onclick="confirmDelete({{ $article->id }})"><i class="fas fa-trash"></i> Удалить</a>
                                    @endcan
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="no-articles">
                <p>Статьи пока не созданы</p>
            </div>
        @endforelse
    </div>

    <div class="pagination-container">
        {{ $articles->links() }}
    </div>
</main>

<!-- Модальное окно создания статьи -->
<div id="createArticleModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('createArticleModal')">&times;</span>
        <h2>Создание новой статьи</h2>
        <form id="createArticleForm" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="articleTitle">Название статьи *</label>
                <input type="text" id="articleTitle" name="title" required>
            </div>
            <div class="form-group">
                <label for="articleContent">Содержание *</label>
                <div id="editorCreate" style="height: 300px;"></div>
                <input type="hidden" id="articleContent" name="content">
            </div>
            <div class="form-group">
                <label for="articleImage">Изображение</label>
                <input type="file" id="articleImage" name="image" accept="image/*">
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('createArticleModal')">Отмена</button>
                <button type="button" class="btn-submit" onclick="submitArticleForm()">Создать статью</button>
            </div>
        </form>
    </div>
</div>

<!-- Модальное окно просмотра статьи -->
<div id="viewArticleModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('viewArticleModal')">&times;</span>
        <h2 id="viewArticleTitle"></h2>
        <div class="article-view">
            <img id="viewArticleImage" src="" alt="" style="display: none; max-width: 100%; margin-bottom: 15px;">
            <div id="viewArticleContent" class="article-content-view"></div>
            <div class="article-meta-view">
                <span><i class="fas fa-calendar-alt"></i> <span id="viewArticleDate"></span></span>
                <span><i class="fas fa-user"></i> <span id="viewArticleAuthor"></span></span>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно подтверждения удаления -->
<div id="deleteArticleModal" class="modal">
    <div class="modal-content small">
        <h2>Подтверждение удаления</h2>
        <p>Вы уверены, что хотите удалить эту статью?</p>
        <p class="text-muted">Статью можно будет восстановить в течение недели.</p>
        <div class="form-actions">
            <button type="button" class="btn-cancel" onclick="closeModal('deleteArticleModal')">Отмена</button>
            <form id="deleteArticleForm" method="POST" style="display: inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-delete">Удалить</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    // Инициализация редактора
    const quillCreate = new Quill('#editorCreate', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'Начните вводить текст статьи...'
    });

    // Функция для отправки формы
    async function submitArticleForm() {
        try {
            // Получаем HTML-содержимое редактора
            const content = quillCreate.root.innerHTML;
            document.getElementById('articleContent').value = content;

            // Проверяем заполнение обязательных полей
            const title = document.getElementById('articleTitle').value.trim();
            if (!title || !content || content === '<p><br></p>') {
                showError('Пожалуйста, заполните все обязательные поля');
                return;
            }

            // Создаем FormData
            const form = document.getElementById('createArticleForm');
            const formData = new FormData(form);

            const response = await fetch('/stati', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData,
                credentials: 'include'
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Ошибка сервера');
            }

            if (data.success) {
                closeModal('createArticleModal');
                window.location.reload();
            } else {
                showError(data.message || 'Ошибка при создании статьи');
            }
        } catch (error) {
            console.error('Error:', error);
            showError(error.message);
        }
    }

    // Просмотр статьи
    async function showArticle(articleId) {
        try {
            const response = await fetch(`/stati/${articleId}`);
            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Ошибка загрузки статьи');
            }

            document.getElementById('viewArticleTitle').textContent = data.title;
            document.getElementById('viewArticleContent').innerHTML = data.content;
            document.getElementById('viewArticleDate').textContent = data.created_at;
            document.getElementById('viewArticleAuthor').textContent = data.author;

            const imgElement = document.getElementById('viewArticleImage');
            if (data.image_url) {
                imgElement.src = data.image_url;
                imgElement.style.display = 'block';
            } else {
                imgElement.style.display = 'none';
            }

            showModal('viewArticleModal');
        } catch (error) {
            console.error('Error:', error);
            showError(error.message);
        }
    }

    // Подтверждение удаления
    function confirmDelete(articleId) {
        document.getElementById('deleteArticleForm').action = `/stati/${articleId}`;
        showModal('deleteArticleModal');
    }

    // Обработчик для формы удаления
    document.getElementById('deleteArticleForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        try {
            const response = await fetch(this.action, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                credentials: 'include'
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Ошибка сервера');
            }

            if (data.success) {
                closeModal('deleteArticleModal');
                window.location.reload();
            } else {
                showError(data.message || 'Ошибка при удалении статьи');
            }
        } catch (error) {
            console.error('Error:', error);
            showError(error.message);
        }
    });

    // Общие функции для модальных окон
    function showModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Функция для отображения ошибок
    function showError(message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger';
        alertDiv.textContent = message;
        
        const container = document.querySelector('.articles-container');
        container.insertBefore(alertDiv, container.firstChild);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }

    // Закрытие модальных окон при клике вне их
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>
</body>
</html> 