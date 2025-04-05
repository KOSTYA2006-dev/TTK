<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@stack('styles')

<style>
/* Основные цвета и переменные */
:root {
    --primary-color: #e31235;      /* Красный цвет ТТК */
    --secondary-color: #0056b3;    /* Синий цвет ТТК */
    --light-gray: #f5f5f5;
    --dark-gray: #333333;
    --text-color: #2c3e50;
    --border-radius: 8px;
}

/* Общие стили */
body {
    font-family: 'Roboto', sans-serif;
    color: var(--text-color);
    line-height: 1.6;
    background-color: var(--light-gray);
}

/* Контейнеры */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Карточки и блоки */
.card {
    background: #fff;
    border-radius: var(--border-radius);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Кнопки */
.btn {
    padding: 0.75rem 1.5rem;
    border-radius: var(--border-radius);
    font-weight: 500;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
}

.btn-primary {
    background: var(--primary-color);
    color: #fff;
}

.btn-primary:hover {
    background: #c41030;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(227, 18, 53, 0.2);
}

.btn-secondary {
    background: var(--secondary-color);
    color: #fff;
}

.btn-secondary:hover {
    background: #004494;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 86, 179, 0.2);
}

/* Формы */
.form-group {
    margin-bottom: 1.5rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #ddd;
    border-radius: var(--border-radius);
    transition: all 0.3s ease;
    background: #fff;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(227, 18, 53, 0.25);
    outline: none;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-color);
}

/* Таблицы */
.table {
    width: 100%;
    background: #fff;
    border-radius: var(--border-radius);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.table th {
    background: var(--secondary-color);
    color: #fff;
    padding: 1rem;
    text-align: left;
}

.table td {
    padding: 1rem;
    border-bottom: 1px solid #eee;
}

.table tr:last-child td {
    border-bottom: none;
}

/* Модальные окна */
.modal {
    background: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background: #fff;
    border-radius: var(--border-radius);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.modal-header {
    border-bottom: 1px solid #eee;
    padding: 1.5rem;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    border-top: 1px solid #eee;
    padding: 1.5rem;
}

/* Навигация по страницам */
.pagination {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin: 2rem 0;
}

.pagination .page-item {
    list-style: none;
}

.pagination .page-link {
    padding: 0.5rem 1rem;
    border-radius: var(--border-radius);
    background: #fff;
    color: var(--text-color);
    text-decoration: none;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background: var(--primary-color);
    color: #fff;
}

.pagination .active .page-link {
    background: var(--primary-color);
    color: #fff;
}

/* Уведомления */
.alert {
    padding: 1rem 1.5rem;
    border-radius: var(--border-radius);
    margin-bottom: 1rem;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-warning {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeeba;
}

.alert-info {
    background: #d1ecf1;
    color: #0c5460;
    border: 1px solid #bee5eb;
}

/* Списки */
.list-group {
    border-radius: var(--border-radius);
    overflow: hidden;
}

.list-group-item {
    padding: 1rem 1.5rem;
    background: #fff;
    border-bottom: 1px solid #eee;
    transition: all 0.3s ease;
}

.list-group-item:last-child {
    border-bottom: none;
}

.list-group-item:hover {
    background: var(--light-gray);
}

/* Вкладки */
.nav-tabs {
    border-bottom: 1px solid #dee2e6;
    margin-bottom: 1.5rem;
}

.nav-tabs .nav-link {
    padding: 0.75rem 1.5rem;
    border: none;
    border-bottom: 2px solid transparent;
    color: var(--text-color);
    transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover {
    border-bottom-color: var(--primary-color);
    color: var(--primary-color);
}

.nav-tabs .nav-link.active {
    border-bottom-color: var(--primary-color);
    color: var(--primary-color);
}

/* Утилиты */
.text-primary {
    color: var(--primary-color) !important;
}

.text-secondary {
    color: var(--secondary-color) !important;
}

.bg-primary {
    background-color: var(--primary-color) !important;
}

.bg-secondary {
    background-color: var(--secondary-color) !important;
}

.shadow {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
}

.shadow-lg {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
}

/* Адаптивность */
@media (max-width: 768px) {
    .container {
        padding: 0 0.75rem;
    }

    .card {
        padding: 1rem;
    }

    .btn {
        padding: 0.5rem 1rem;
    }

    .table {
        display: block;
        overflow-x: auto;
    }
}

/* Анимации */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.3s ease-in-out;
}

/* Profile styles */
.profile-card {
    transition: all 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.card-img-top {
    transition: transform 0.3s ease;
}

.card:hover .card-img-top {
    transform: scale(1.05);
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background-color: #c41030;
    border-color: #c41030;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .profile-card {
        margin-bottom: 2rem;
    }
}
</style> 