<!-- Модальное окно для входа/регистрации -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <ul class="nav nav-tabs" id="authTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Вход</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">Регистрация</button>
                    </li>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="authTabContent">
                    <!-- Вкладка входа -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf
                            <div class="mb-3">
                                <label for="login-input" class="form-label">Логин</label>
                                <input type="text" class="form-control" id="login-input" name="login" required>
                            </div>
                            <div class="mb-3">
                                <label for="password-input" class="form-label">Пароль</label>
                                <input type="password" class="form-control" id="password-input" name="password" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Запомнить меня</label>
                            </div>
                            <div class="alert alert-danger d-none" id="login-error"></div>
                            <button type="submit" class="btn btn-primary w-100">Войти</button>
                        </form>
                    </div>
                    <!-- Вкладка регистрации -->
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf
                            <div class="mb-3">
                                <label for="full_name" class="form-label">ФИО</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="register-login" class="form-label">Логин</label>
                                <input type="text" class="form-control" id="register-login" name="login" required>
                            </div>
                            <div class="mb-3">
                                <label for="register-password" class="form-label">Пароль</label>
                                <input type="password" class="form-control" id="register-password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">Подтверждение пароля</label>
                                <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                            </div>
                            <div class="alert alert-danger d-none" id="register-error"></div>
                            <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Обработка формы входа
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const errorDiv = $('#login-error');
        
        // Отключаем кнопку на время отправки
        submitBtn.prop('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    errorDiv.text(response.message || 'Произошла ошибка при входе');
                    errorDiv.removeClass('d-none');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    errorDiv.text(xhr.responseJSON.message || 'Неверные учетные данные');
                } else {
                    errorDiv.text('Произошла ошибка при входе');
                }
                errorDiv.removeClass('d-none');
                handleAjaxError(xhr);
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
        
        // Отключаем кнопку на время отправки
        submitBtn.prop('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    errorDiv.text(response.message || 'Произошла ошибка при регистрации');
                    errorDiv.removeClass('d-none');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    errorDiv.text(xhr.responseJSON.message || 'Ошибка валидации данных');
                } else {
                    errorDiv.text('Произошла ошибка при регистрации');
                }
                errorDiv.removeClass('d-none');
                handleAjaxError(xhr);
            },
            complete: function() {
                submitBtn.prop('disabled', false);
            }
        });
    });

    // Очистка ошибок при переключении вкладок
    $('#authModal').on('shown.bs.tab', 'button[data-bs-toggle="tab"]', function() {
        $('#login-error, #register-error').addClass('d-none');
    });

    // Очистка ошибок при открытии модального окна
    $('#authModal').on('show.bs.modal', function() {
        $('#login-error, #register-error').addClass('d-none');
        $('#loginForm, #registerForm').trigger('reset');
    });
});
</script> 