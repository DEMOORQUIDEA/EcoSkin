@extends('layouts.app')

@section('content')
<style>
    .admin-login-container {
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
        border-radius: 20px;
        box-shadow: 0 30px 70px rgba(45, 45, 38, 0.2);
        overflow: hidden;
        max-width: 450px;
        width: 100%;
        border: 1px solid rgba(186, 155, 114, 0.2);
    }

    .login-header {
        background: var(--color-charcoal);
        color: var(--color-cream);
        padding: 3rem 2rem;
        text-align: center;
        position: relative;
    }

    .login-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--color-forest);
    }

    .login-header h3 {
        margin: 0;
        font-family: 'Cormorant Garamond', serif;
        font-weight: 600;
        font-size: 2.2rem;
        letter-spacing: 0.05em;
    }

    .login-header p {
        margin: 0.75rem 0 0;
        opacity: 0.8;
        font-size: 0.95rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .login-body {
        padding: 3rem 2.5rem;
    }

    .form-floating {
        margin-bottom: 1.5rem;
    }

    .form-floating > .form-control {
        border: 1.5px solid #e0e6ed;
        border-radius: 12px;
        padding: 1rem 0.75rem;
        height: calc(3.5rem + 2px);
        transition: all 0.3s ease;
    }

    .form-floating > .form-control:focus {
        border-color: var(--color-forest);
        box-shadow: 0 0 0 0.25rem rgba(88, 98, 74, 0.15);
    }

    .btn-admin {
        background: var(--color-charcoal);
        border: 2px solid var(--color-forest);
        border-radius: 10px;
        padding: 1rem;
        font-weight: 600;
        font-size: 1.1rem;
        letter-spacing: 0.08em;
        color: var(--color-forest);
        width: 100%;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        text-transform: uppercase;
        margin-top: 1rem;
    }

    .btn-admin:hover {
        background: var(--color-forest);
        color: var(--color-cream);
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(88, 98, 74, 0.3);
        border-color: var(--color-forest);
    }

    .admin-notice {
        text-align: center;
        margin-top: 2rem;
        color: #8492a6;
        font-size: 0.85rem;
        font-style: italic;
    }

    .icon-box {
        width: 64px;
        height: 64px;
        background: rgba(88, 98, 74, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        border: 2px solid var(--color-forest);
    }

    .icon-box i {
        font-size: 2.2rem;
        color: var(--color-forest);
    }
</style>

<div class="admin-login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="icon-box">
                <i class="bi bi-shield-lock"></i>
            </div>
            <h3>Administración</h3>
            <p>Acceso Restringido</p>
        </div>

        <div class="login-body">
            <form method="POST" action="{{ route('admin.login.submit') }}">
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
                           placeholder="admin@orquidea.com">
                    <label for="email">
                        <i class="bi bi-person-badge me-2"></i>Correo Administrativo
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
                        <i class="bi bi-key me-2"></i>Contraseña Maestra
                    </label>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-admin">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Entrar al Panel
                </button>

                <div class="admin-notice">
                    <i class="bi bi-info-circle me-1"></i>
                    Solo personal autorizado de Orquidea puede acceder a este panel.
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
