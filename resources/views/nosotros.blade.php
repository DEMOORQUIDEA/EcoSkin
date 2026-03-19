@extends('layouts.app')

@section('content')

{{-- ====================================================
     ECOSKIN — Página "Nosotros"
     Paleta Ecológica: #EBF2E8 · #8DB600 · #8F9D7D · #48633F · #1B2B1B
==================================================== --}}

<section class="nosotros-hero">
    <div class="container text-center">
        <span class="eco-hero__tag">Nuestra Historia</span>
        <h1 class="nosotros-title">EcoSkin Cosmetics</h1>
        <p class="nosotros-subtitle">Donde la ciencia de la naturaleza se encuentra con la pasión artesanal.</p>
    </div>
</section>

<section class="nosotros-historia py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="historia-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1556228578-0d85b1a4d571?q=80&w=1000&auto=format&fit=crop" alt="Botanical Ingredients" class="img-fluid rounded-4 shadow-lg">
                    <div class="historia-badge">Desde 2026</div>
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5">
                <h2 class="section-title mb-4">EcoSkin Cosmetics: Nuestra Esencia</h2>
                <p class="lead text-muted mb-4">EcoSkin Cosmetics nació con un propósito claro: redefinir el cuidado de la piel a través de la pureza de lo natural.</p>
                <p class="text-muted mb-4">No solo creamos productos; formulamos experiencias sensoriales que respetan tu cuerpo y el medio ambiente. Cada ingrediente es seleccionado por su eficacia biológica y su origen ético, garantizando que lo que aplicas en tu piel es tan noble como la tierra misma.</p>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 bg-white rounded-3 shadow-sm border-start border-4 border-forest">
                            <h5 class="mb-1 text-forest">{{ __('Misión') }}</h5>
                            <small class="text-muted">{{ __('Empoderar la belleza natural con ciencia orgánica.') }}</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-white rounded-3 shadow-sm border-start border-4 border-tan">
                            <h5 class="mb-1 text-tan">{{ __('Visión') }}</h5>
                            <small class="text-muted">{{ __('Ser el referente global en cosmética consciente.') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="creadores-section py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-tan text-uppercase fw-bold ls-2 d-block mb-2">{{ __('El Equipo') }}</span>
            <h2 class="section-title">{{ __('Nuestros 5 Creadores') }}</h2>
            <div class="title-divider mx-auto"></div>
        </div>

        <div class="row g-4 justify-content-center">
            @php
                $creadores = [
                    ['nombre' => 'Alejandro Rodríguez', 'puesto' => 'Director General', 'bio' => 'Líder visionario en cosmética natural.'],
                    ['nombre' => 'Orquidea Solórzano', 'puesto' => 'Directora Creativa', 'bio' => 'Alma del diseño y estética EcoSkin.'],
                    ['nombre' => 'Karen Rodríguez', 'puesto' => 'Jefa de Formulación', 'bio' => 'Experta en botánica y principios activos.'],
                    ['nombre' => 'Obet López', 'puesto' => 'Maestro Artesano', 'bio' => 'Guardián de los procesos tradicionales.'],
                    ['nombre' => 'Dayana Peñate', 'puesto' => 'Estratega de Marca', 'bio' => 'Impulsora de la belleza consciente.']
                ];
            @endphp

            @foreach($creadores as $creador)
                <div class="col-md-4 col-lg-2-4">
                    <div class="creador-card text-center h-100">
                        <div class="creador-avatar mb-3">
                            <i class="bi bi-person-circle text-sage" style="font-size: 4rem;"></i>
                        </div>
                        <h5 class="mb-1">{{ $creador['nombre'] }}</h5>
                        <p class="text-tan small fw-bold mb-2">{{ $creador['puesto'] }}</p>
                        <p class="text-muted smallest">{{ $creador['bio'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .nosotros-hero {
        background: linear-gradient(rgba(45, 45, 38, 0.8), rgba(45, 45, 38, 0.8)), url('https://images.unsplash.com/photo-1540555700478-4be289aefcf1?q=80&w=2000&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        padding: 8rem 0;
        color: var(--color-cream);
        margin-top: -2rem;
    }

    .nosotros-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 4rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .nosotros-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }

    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.5rem;
        color: var(--color-charcoal);
    }

    .title-divider {
        width: 60px;
        height: 3px;
        background: var(--color-tan);
        margin-top: 1rem;
    }

    .historia-img-wrapper {
        position: relative;
    }

    .historia-badge {
        position: absolute;
        bottom: -20px;
        right: -20px;
        background: var(--color-forest);
        color: white;
        padding: 1.5rem;
        border-radius: 50%;
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .creador-card {
        padding: 2rem;
        background: var(--color-cream);
        border-radius: 20px;
        transition: all 0.3s ease;
        border: 1px solid rgba(162, 165, 141, 0.2);
    }

    .creador-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        border-color: var(--color-tan);
    }

    .ls-2 { letter-spacing: 0.2em; }
    .text-forest { color: var(--color-forest); }
    .text-tan { color: var(--color-tan); }
    .bg-forest { background-color: var(--color-forest); }
    .border-forest { border-color: var(--color-forest) !important; }
    .border-tan { border-color: var(--color-tan) !important; }
    .smallest { font-size: 0.75rem; }

    @media (min-width: 992px) {
        .col-lg-2-4 {
            width: 20%;
        }
    }
</style>

@endsection
