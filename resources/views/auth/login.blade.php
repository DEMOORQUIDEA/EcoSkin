@extends('layouts.app')

@section('content')
<style>
    .login-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--color-cream);
        margin: -1.5rem -0.75rem 0;
        padding: 2rem 0.75rem;
    }

    .login-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(45, 45, 38, 0.15);
        overflow: hidden;
        max-width: 450px;
        width: 100%;
    }

    .login-header {
        background: var(--color-charcoal);
        color: var(--color-cream);
        padding: 2.5rem 2rem;
        text-align: center;
    }

    .login-header h3 {
        margin: 0;
        font-family: 'Cormorant Garamond', serif;
        font-weight: 500;
        font-size: 2rem;
        letter-spacing: 0.04em;
    }

    .login-header p {
        margin: 0.5rem 0 0;
        opacity: 0.7;
        font-size: 0.9rem;
        letter-spacing: 0.03em;
    }

    .login-body {
        padding: 2.5rem;
    }

    .form-floating {
        margin-bottom: 1.5rem;
    }

    .form-floating > .form-control {
        border: 2px solid #e0e6ed;
        border-radius: 10px;
        padding: 1rem 0.75rem;
        height: calc(3.5rem + 2px);
        transition: all 0.3s ease;
    }

    .form-floating > .form-control:focus {
        border-color: var(--color-sage);
        box-shadow: 0 0 0 0.2rem rgba(162, 165, 141, 0.2);
    }

    .form-floating > label {
        padding: 1rem 0.75rem;
        color: #8492a6;
    }

    .form-check-input:checked {
        background-color: var(--color-forest);
        border-color: var(--color-forest);
    }

    .btn-login {
        background: var(--color-forest);
        border: none;
        border-radius: 8px;
        padding: 0.875rem;
        font-weight: 500;
        font-size: 1rem;
        letter-spacing: 0.04em;
        color: var(--color-cream);
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(88, 98, 74, 0.25);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(88, 98, 74, 0.35);
        background: var(--color-charcoal);
        color: var(--color-cream);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .forgot-password {
        color: var(--color-sage);
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .forgot-password:hover {
        color: var(--color-forest);
        text-decoration: underline;
    }

    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 1.5rem 0;
        color: #8492a6;
        font-size: 0.9rem;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e0e6ed;
    }

    .divider span {
        padding: 0 1rem;
    }

    .register-link {
        text-align: center;
        margin-top: 1.5rem;
        color: #8492a6;
        font-size: 0.95rem;
    }

    .register-link a {
        color: var(--color-forest);
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .register-link a:hover {
        color: var(--color-tan);
        text-decoration: underline;
    }

    .icon-box {
        width: 56px;
        height: 56px;
        background: rgba(230, 234, 221, 0.15);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        border: 1.5px solid rgba(186, 155, 114, 0.3);
    }

    .icon-box i {
        font-size: 2rem;
    }

    @media (max-width: 576px) {
        .login-card {
            margin: 0 1rem;
        }

        .login-body {
            padding: 1.5rem;
        }
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="icon-box">
                <i class="bi bi-lock-fill"></i>
            </div>
            <h3>{{ __('Login') }}</h3>
            <p>{{ __('Bienvenido de nuevo, ingresa tus credenciales') }}</p>
        </div>

        <div class="login-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-floating">
                    <input id="email"
                           type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email"
                           autofocus
                           placeholder="nombre@ejemplo.com">
                    <label for="email">
                        <i class="bi bi-envelope me-2"></i>{{ __('Email Address') }}
                    </label>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input id="password"
                           type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password"
                           required
                           autocomplete="current-password"
                           placeholder="Contraseña">
                    <label for="password">
                        <i class="bi bi-key me-2"></i>{{ __('Password') }}
                    </label>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input"
                           type="checkbox"
                           name="remember"
                           id="remember"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                    <div class="text-center mt-3">
                        <a class="forgot-password" href="{{ route('password.request') }}">
                            <i class="bi bi-question-circle me-1"></i>{{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                @endif
            </form>

            @if (Route::has('register'))
                <div class="divider">
                    <span>O</span>
                </div>

                <div class="register-link">
                    {{ __('¿No tienes una cuenta?') }} <a href="{{ route('register') }}">{{ __('Regístrate aquí') }}</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
