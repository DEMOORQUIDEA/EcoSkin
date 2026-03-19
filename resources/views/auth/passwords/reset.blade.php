@extends('layouts.app')

@section('content')
<style>
    .reset-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--color-cream);
        margin: -1.5rem -0.75rem 0;
        padding: 2rem 0.75rem;
    }

    .reset-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 30px 70px rgba(45, 45, 38, 0.15);
        overflow: hidden;
        max-width: 500px;
        width: 100%;
        border: 1px solid rgba(162, 165, 141, 0.1);
    }

    .reset-header {
        background: var(--color-charcoal);
        color: var(--color-cream);
        padding: 2.5rem 2rem;
        text-align: center;
        position: relative;
    }

    .reset-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--color-forest);
    }

    .reset-header h3 {
        margin: 0;
        font-family: 'Cormorant Garamond', serif;
        font-weight: 500;
        font-size: 2rem;
        letter-spacing: 0.04em;
    }

    .reset-body {
        padding: 2.5rem;
    }

    .form-floating {
        margin-bottom: 1.25rem;
    }

    .btn-reset {
        background: var(--color-forest);
        border: none;
        border-radius: 10px;
        padding: 1rem;
        font-weight: 500;
        font-size: 1rem;
        letter-spacing: 0.05em;
        color: var(--color-cream);
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(88, 98, 74, 0.2);
        margin-top: 1rem;
    }

    .btn-reset:hover {
        background: var(--color-charcoal);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(45, 45, 38, 0.25);
    }

    .icon-box {
        width: 56px;
        height: 56px;
        background: rgba(88, 98, 74, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        border: 1.5px solid rgba(88, 98, 74, 0.2);
    }

    .icon-box i {
        font-size: 1.8rem;
        color: var(--color-forest);
    }
</style>

<div class="reset-container">
    <div class="reset-card">
        <div class="reset-header">
            <div class="icon-box">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h3>{{ __('Nueva Contraseña') }}</h3>
            <p class="small text-uppercase tracking-wider opacity-75">{{ __('Define tu nueva clave de acceso') }}</p>
        </div>

        <div class="reset-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-floating">
                    <input id="email" 
                           type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ $email ?? old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus
                           placeholder="nombre@ejemplo.com">
                    <label for="email">
                        <i class="bi bi-envelope me-2"></i>{{ __('Correo Electrónico') }}
                    </label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating">
                    <input id="password" 
                           type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" 
                           required 
                           autocomplete="new-password"
                           placeholder="Nueva contraseña">
                    <label for="password">
                        <i class="bi bi-key me-2"></i>{{ __('Nueva Contraseña') }}
                    </label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
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
                        <i class="bi bi-shield-check me-2"></i>{{ __('Confirmar Contraseña') }}
                    </label>
                </div>

                <button type="submit" class="btn btn-reset">
                    <i class="bi bi-check2-circle me-1"></i> {{ __('Restablecer Contraseña') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
