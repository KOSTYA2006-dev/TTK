@include('layouts.styles')

<header class="navbar navbar-expand-lg navbar-dark bg-danger sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <i class="fas fa-globe-americas me-2"></i>
            <span>TTK</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('articles*') ? 'active' : '' }}" href="{{ route('articles.index') }}">
                        <i class="fas fa-newspaper me-1"></i> Статьи
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('tasks*') ? 'active' : '' }}" href="{{ route('tasks.index') }}">
                        <i class="fas fa-tasks me-1"></i> Задачи
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about*') ? 'active' : '' }}" href="{{ url('/about') }}">
                        <i class="fas fa-info-circle me-1"></i> О нас
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contact*') ? 'active' : '' }}" href="{{ url('/contact') }}">
                        <i class="fas fa-envelope me-1"></i> Игра
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#authModal">
                            <i class="fas fa-sign-in-alt me-1"></i> Вход / Регистрация
                        </button>
                    </li>
                @endguest
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="me-2">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="d-none d-sm-inline">{{ Auth::user()->full_name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ url('/profile') }}">
                                    <i class="fas fa-user me-2"></i> Мой профиль
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/my-tours') }}">
                                    <i class="fas fa-suitcase me-2"></i> Мои туры
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/favorites') }}">
                                    <i class="fas fa-heart me-2"></i> Избранное
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/settings') }}">
                                    <i class="fas fa-cog me-2"></i> Настройки
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-danger p-0 w-100 text-start">
                                        <i class="fas fa-sign-out-alt me-2"></i> Выход
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</header>


<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <ul class="nav nav-tabs w-100" id="authTab" role="tablist">
                    <li class="nav-item flex-grow-1 text-center" role="presentation">
                        <button class="nav-link active w-100" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">
                            <i class="fas fa-sign-in-alt me-2"></i>Вход
                        </button>
                    </li>
                    <li class="nav-item flex-grow-1 text-center" role="presentation">
                        <button class="nav-link w-100" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">
                            <i class="fas fa-user-plus me-2"></i>Регистрация
                        </button>
                    </li>
                </ul>
                <button type="button" class="btn-close position-absolute" style="right: 1rem; top: 1rem;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <div class="tab-content" id="authTabContent">
                    <!-- Вкладка входа -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf
                            <div class="mb-3">
                                <label for="login-input" class="form-label">
                                    <i class="fas fa-user me-2"></i>Логин
                                </label>
                                <input type="text" class="form-control" id="login-input" name="login" required>
                            </div>
                            <div class="mb-3">
                                <label for="password-input" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Пароль
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password-input" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password-input')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Запомнить меня</label>
                            </div>
                            <div class="alert alert-danger d-none" id="login-error"></div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Войти
                            </button>
                        </form>
                    </div>
                    <!-- Вкладка регистрации -->
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf
                            <div class="mb-3">
                                <label for="full_name" class="form-label">
                                    <i class="fas fa-user me-2"></i>ФИО
                                </label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="register-login" class="form-label">
                                    <i class="fas fa-user-circle me-2"></i>Логин
                                </label>
                                <input type="text" class="form-control" id="register-login" name="login" required>
                            </div>
                            <div class="mb-3">
                                <label for="register-password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Пароль
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="register-password" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('register-password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Подтверждение пароля
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password-confirm')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="alert alert-danger d-none" id="register-error"></div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus me-2"></i>Зарегистрироваться
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        button.classList.remove('fa-eye');
        button.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        button.classList.remove('fa-eye-slash');
        button.classList.add('fa-eye');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Обработка формы входа
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const errorDiv = $('#login-error');
        
        submitBtn.prop('disabled', true);
        errorDiv.addClass('d-none');
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    errorDiv.removeClass('d-none').text(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    errorDiv.removeClass('d-none').text(Object.values(errors)[0][0]);
                } else {
                    errorDiv.removeClass('d-none').text('Произошла ошибка. Попробуйте позже.');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false);
            }
        });
    });

    // Обработка формы регистрации
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const errorDiv = $('#register-error');
        
        submitBtn.prop('disabled', true);
        errorDiv.addClass('d-none');
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    errorDiv.removeClass('d-none').text(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    errorDiv.removeClass('d-none').text(Object.values(errors)[0][0]);
                } else {
                    errorDiv.removeClass('d-none').text('Произошла ошибка. Попробуйте позже.');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false);
            }
        });
    });

    // Очистка ошибок при переключении вкладок
    $('#authTab button').on('click', function() {
        $('#login-error, #register-error').addClass('d-none');
    });

    // Очистка ошибок при открытии модального окна
    $('#authModal').on('show.bs.modal', function() {
        $('#login-error, #register-error').addClass('d-none');
        $('#loginForm, #registerForm')[0].reset();
    });
});
</script>
@endpush