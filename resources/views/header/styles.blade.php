<style>
/* Кастомные стили для хедера */
.navbar {
    background-color: #dc2626 !important;
    box-shadow: 0 2px 4px rgba(0,0,0,.1);
    padding: 0.5rem 0;
}

.navbar .container {
    background-color: #dc2626 !important;
    padding: 0.5rem 1rem;
    border-radius: 8px;
}

.navbar-brand {
    font-size: 1.5rem;
    font-weight: 600;
    transition: transform 0.3s ease;
    color: #fff !important;
}

.navbar-brand:hover {
    transform: scale(1.05);
}

.navbar-brand i {
    font-size: 1.75rem;
    color: #fff;
}

.navbar-nav {
    margin: 0 auto;
}

.nav-link {
    font-weight: 500;
    padding: 0.5rem 1rem !important;
    position: relative;
    transition: color 0.3s ease;
    color: rgba(255, 255, 255, 0.9) !important;
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: #fff;
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.nav-link:hover::after {
    width: 80%;
}

.nav-link:hover {
    color: #fff !important;
}

.nav-link.active {
    color: #fff !important;
}

.nav-link.active::after {
    width: 80%;
}

.nav-link i {
    font-size: 1.1rem;
}

/* Стили для кнопки входа/регистрации */
.btn-primary {
    background: #fff;
    color: #dc2626;
    border: none;
    padding: 0.5rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: rgba(255, 255, 255, 0.9);
    color: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Стили для выпадающего меню */
.dropdown-menu {
    background: #dc2626;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px;
    padding: 0.5rem;
    min-width: 220px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.dropdown-item {
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    transform: translateX(5px);
}

.dropdown-item.text-danger:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
}

.dropdown-divider {
    border-color: rgba(255,255,255,0.1);
    margin: 0.5rem 0;
}

/* Стили для модального окна */
.modal-content {
    border-radius: 12px;
    border: none;
}

.modal-header {
    padding: 1rem;
}

.nav-tabs {
    border: none;
    gap: 0.5rem;
}

.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    padding: 0.75rem 1.5rem !important;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover {
    color: #dc2626;
    transform: none;
}

.nav-tabs .nav-link.active {
    background: #dc2626;
    color: #fff !important;
}

.modal-body {
    padding: 1.5rem;
}

.form-label {
    font-weight: 500;
    color: #495057;
}

.form-control {
    border-radius: 8px;
    padding: 0.75rem 1rem;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #dc2626;
    box-shadow: 0 0 0 0.25rem rgba(220, 38, 38, 0.25);
}

.input-group .btn {
    border-radius: 0 8px 8px 0;
}

.alert {
    border-radius: 8px;
    padding: 0.75rem 1rem;
}

/* Адаптивность */
@media (max-width: 991.98px) {
    .navbar-collapse {
        background: #dc2626;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
    }

    .nav-link {
        padding: 0.75rem 1rem !important;
    }

    .nav-link::after {
        display: none;
    }

    .dropdown-menu {
        background: #dc2626;
        border: none;
        margin-top: 0.5rem;
    }
}
</style> 