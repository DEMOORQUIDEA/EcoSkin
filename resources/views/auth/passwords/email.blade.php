@extends('layouts.app')

@section('content')
<style>
    .recovery-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--color-cream);
        margin: -1.5rem -0.75rem 0;
        padding: 2rem 0.75rem;
    }

    .recovery-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 30px 70px rgba(45, 45, 38, 0.15);
        overflow: hidden;
        max-width: 450px;
        width: 100%;
        border: 1px solid rgba(162, 165, 141, 0.1);
    }

    .recovery-header {
        background: var(--color-charcoal);
        color: var(--color-cream);
        padding: 3rem 2rem;
        text-align: center;
        position: relative;
    }

    .recovery-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--color-forest);
    }

    .recovery-header h3 {
        margin: 0;
        font-family: 'Cormorant Garamond', serif;
        font-weight: 500;
        font-size: 2rem;
        letter-spacing: 0.04em;
    }

    .recovery-header p {
        margin: 0.75rem 0 0;
        opacity: 0.7;
        font-size: 0.9rem;
        letter-spacing: 0.03em;
    }

    .recovery-body {
        padding: 3rem 2.5rem;
    }

    .form-floating {
        margin-bottom: 2rem;
    }

    .btn-recovery {
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
    }

    .btn-recovery:hover {
        background: var(--color-charcoal);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(45, 45, 38, 0.25);
    }

    .icon-box {
        width: 60px;
        height: 60px;
        background: rgba(88, 98, 74, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        border: 1.5px solid rgba(88, 98, 74, 0.2);
    }

    .icon-box i {
        font-size: 2rem;
        color: var(--color-forest);
    }

    .back-link {
        text-align: center;
        margin-top: 1.5rem;
    }

    .back-link a {
        color: var(--color-sage);
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s;
    }

    .back-link a:hover {
        color: var(--color-tan);
    }
</style>

<div class="recovery-container">
    <div class="recovery-card">
        <div class="recovery-header">
            <div class="icon-box">
                <i class="bi bi-envelope-heart"></i>
            </div>
            <h3>{{ __('Recuperar Acceso') }}</h3>
            <p>{{ __('Te enviaremos un enlace para restablecer tu contraseña') }}</p>
        </div>

        <div class="recovery-body">
            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px; background: rgba(88, 98, 74, 0.1); color: var(--color-forest);">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
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
                        <i class="bi bi-envelope me-2"></i>{{ __('Correo Electrónico') }}
                    </label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-recovery">
                    <i class="bi bi-send-fill me-2"></i> {{ __('Enviar Enlace') }}
                </button>
            </form>

            <div class="back-link">
                <a href="{{ route('login') }}">
                    <i class="bi bi-arrow-left me-1"></i> {{ __('Volver al inicio de sesión') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
