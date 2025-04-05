@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="auth-card card shadow-lg">
                <div class="card-header text-center">
                    <img src="{{ asset('images/ttk-logo.png') }}" alt="ТТК" class="auth-logo">
                    <h4 class="mt-3 mb-0">Регистрация</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="auth-form">
                        @csrf

                        <div class="form-group">
                            <label for="full_name" class="form-label">
                                <i class="fas fa-user"></i>
                                ФИО
                            </label>
                            <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                   name="full_name" value="{{ old('full_name') }}" required autocomplete="full_name" autofocus>
                            @error('full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="login" class="form-label">
                                <i class="fas fa-user-circle"></i>
                                Логин
                            </label>
                            <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" 
                                   name="login" value="{{ old('login') }}" required autocomplete="login">
                            @error('login')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i>
                                Пароль
                            </label>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="form-label">
                                <i class="fas fa-lock"></i>
                                Подтверждение пароля
                            </label>
                            <div class="input-group">
                                <input id="password-confirm" type="password" class="form-control" 
                                       name="password_confirmation" required autocomplete="new-password">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password-confirm')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-user-plus"></i> Зарегистрироваться
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.auth-card {
    margin-top: 3rem;
    border: none;
    border-radius: 12px;
    overflow: hidden;
}

.auth-card .card-header {
    background: #fff;
    border-bottom: 1px solid #eee;
    padding: 2rem 1.5rem;
}

.auth-logo {
    height: 40px;
    margin-bottom: 1rem;
}

.auth-form {
    padding: 1rem 0;
}

.auth-form .form-group {
    margin-bottom: 1.5rem;
}

.auth-form .form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-color);
    font-weight: 500;
}

.auth-form .form-label i {
    color: var(--primary-color);
}

.auth-form .form-control {
    border-radius: 8px;
    padding: 0.75rem 1rem;
    border: 1px solid #ddd;
    transition: all 0.3s ease;
}

.auth-form .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(227, 18, 53, 0.25);
}

.auth-form .input-group .btn {
    border-radius: 0 8px 8px 0;
    border: 1px solid #ddd;
    border-left: none;
}

.auth-form .btn-primary {
    width: 100%;
    padding: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

@media (max-width: 768px) {
    .auth-card {
        margin: 1rem;
    }
}
</style>

@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = input.nextElementSibling.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endpush
@endsection 