@extends('layouts.app')

@section('content')
<style>
    .register-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        margin: -1.5rem -0.75rem 0;
        padding: 2rem 0.75rem;
    }

    .register-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        max-width: 500px;
        width: 100%;
    }

    .register-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .register-header h3 {
        margin: 0;
        font-weight: 600;
        font-size: 1.8rem;
    }

    .register-header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .register-body {
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
        border-color: #f093fb;
        box-shadow: 0 0 0 0.2rem rgba(240, 147, 251, 0.15);
    }

    .form-floating > label {
        padding: 1rem 0.75rem;
        color: #8492a6;
    }

    .btn-register {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border: none;
        border-radius: 10px;
        padding: 0.875rem;
        font-weight: 600;
        font-size: 1rem;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3);
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(240, 147, 251, 0.4);
        background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
    }

    .btn-register:active {
        transform: translateY(0);
    }

    .btn-register:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
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

    .login-link {
        text-align: center;
        margin-top: 1.5rem;
        color: #8492a6;
        font-size: 0.95rem;
    }

    .login-link a {
        color: #f093fb;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .login-link a:hover {
        color: #f5576c;
        text-decoration: underline;
    }

    .icon-box {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .icon-box i {
        font-size: 2rem;
    }

    .password-strength {
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: none;
    }

    .strength-bar {
        height: 4px;
        background: #e0e6ed;
        border-radius: 2px;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .strength-bar-fill {
        height: 100%;
        width: 0%;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .strength-weak {
        width: 33%;
        background: #dc3545;
    }

    .strength-medium {
        width: 66%;
        background: #ffc107;
    }

    .strength-strong {
        width: 100%;
        background: #28a745;
    }

    @media (max-width: 576px) {
        .register-card {
            margin: 0 1rem;
        }

        .register-body {
            padding: 1.5rem;
        }
    }
</style>

<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <div class="icon-box">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <h3>Crear Cuenta</h3>
            <p>Completa el formulario para registrarte</p>
        </div>

        <div class="register-body">
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <div class="form-floating">
                    <input id="name"
                           type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           autocomplete="name"
                           autofocus
                           placeholder="Nombre completo">
                    <label for="name">
                        <i class="bi bi-person me-2"></i>Nombre Completo
                    </label>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input id="email"
                           type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email"
                           placeholder="nombre@ejemplo.com">
                    <label for="email">
                        <i class="bi bi-envelope me-2"></i>Correo Electrónico
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
                           autocomplete="new-password"
                           placeholder="Contraseña">
                    <label for="password">
                        <i class="bi bi-key me-2"></i>Contraseña
                    </label>
                    <div class="strength-bar">
                        <div class="strength-bar-fill" id="strengthBar"></div>
                    </div>
                    <div class="password-strength" id="passwordStrength"></div>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-floating">
                    <input id="password-confirm"
                           type="password"
                           class="form-control"
                           name="password_confirmation"
                           required
                           autocomplete="new-password"
                           placeholder="Confirmar contraseña">
                    <label for="password-confirm">
                        <i class="bi bi-shield-check me-2"></i>Confirmar Contraseña
                    </label>
                </div>

                <button type="submit" class="btn btn-register" id="submitBtn">
                    <i class="bi bi-check-circle me-2"></i>Registrarse
                </button>
            </form>

            @if (Route::has('login'))
                <div class="divider">
                    <span>O</span>
                </div>

                <div class="login-link">
                    ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const registerForm = document.getElementById('registerForm');
        const submitButton = document.getElementById('submitBtn');
        const passwordInput = document.getElementById('password');
        const passwordConfirm = document.getElementById('password-confirm');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('passwordStrength');

        if (!registerForm || !submitButton) return;

        const originalButtonText = submitButton.innerHTML;
        let isSubmitting = false;

        // Password strength checker
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;

                if (password.length >= 8) strength++;
                if (password.match(/[a-z]+/)) strength++;
                if (password.match(/[A-Z]+/)) strength++;
                if (password.match(/[0-9]+/)) strength++;
                if (password.match(/[$@#&!]+/)) strength++;

                strengthBar.className = 'strength-bar-fill';
                strengthText.style.display = 'block';

                if (strength === 0) {
                    strengthBar.style.width = '0%';
                    strengthText.textContent = '';
                    strengthText.style.display = 'none';
                } else if (strength <= 2) {
                    strengthBar.classList.add('strength-weak');
                    strengthText.textContent = 'Contraseña débil';
                    strengthText.style.color = '#dc3545';
                } else if (strength <= 4) {
                    strengthBar.classList.add('strength-medium');
                    strengthText.textContent = 'Contraseña media';
                    strengthText.style.color = '#ffc107';
                } else {
                    strengthBar.classList.add('strength-strong');
                    strengthText.textContent = 'Contraseña fuerte';
                    strengthText.style.color = '#28a745';
                }
            });
        }

        // Form submission handler
        registerForm.addEventListener('submit', function(e) {
            // Prevenir múltiples envíos
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }

            // Validar que las contraseñas coincidan
            if (passwordInput && passwordConfirm) {
                if (passwordInput.value !== passwordConfirm.value) {
                    e.preventDefault();
                    alert('Las contraseñas no coinciden');
                    return false;
                }
            }

            // Marcar como enviando
            isSubmitting = true;

            // Deshabilitar el botón
            submitButton.disabled = true;

            // Cambiar el texto y agregar spinner
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Registrando...';

            // Si hay errores de validación, el formulario no se enviará
            // pero necesitamos resetear el botón después de un tiempo
            setTimeout(function() {
                if (window.location.href.includes('register')) {
                    // Si seguimos en la página de registro, probablemente hubo un error
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                    isSubmitting = false;
                }
            }, 3000);
        });
    });
</script>
@endpush
