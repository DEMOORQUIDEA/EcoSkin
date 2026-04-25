@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: #ffffff;">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <h1 class="display-4 fw-bold mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--color-charcoal);">Sobre Orquidea</h1>
                        <div class="mx-auto" style="width: 80px; height: 3px; background: var(--color-forest); border-radius: 2px;"></div>
                    </div>

                    <div class="row align-items-center g-5">
                        <div class="col-md-5">
                            <div class="position-relative">
                                <div class="rounded-4 overflow-hidden shadow-lg border" style="background: var(--color-sage); aspect-ratio: 1/1; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-person-heart text-white" style="font-size: 8rem;"></i>
                                </div>
                                <div class="position-absolute bottom-0 end-0 p-3">
                                    <div class="bg-white rounded-circle shadow p-2" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-mortarboard-fill text-dark fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h3 class="fw-bold mb-4" style="color: var(--color-forest);">Perfil Académico y Profesional</h3>
                            
                            <p class="lead mb-4" style="line-height: 1.8; color: #000000 !important;">
                                Orquidea es una apasionada estudiante de 20 años de edad, actualmente cursando la carrera de 
                                <strong>Tecnologías de la Información y Comunicación</strong> en la 
                                <strong>Universidad Tecnológica de la Selva</strong>.
                            </p>

                            <div class="mb-4">
                                <h6 class="text-uppercase text-muted fw-bold mb-3" style="font-size: 0.85rem; letter-spacing: 1.5px;">Especialidad</h6>
                                <p class="h5 mb-0" style="color: #000000 !important;">
                                    Entornos Virtuales y Negocios Digitales
                                </p>
                            </div>

                            <p class="text-muted" style="line-height: 1.7;">
                                Con un enfoque centrado en la innovación y el diseño digital, Orquidea combina sus conocimientos técnicos 
                                con una visión emprendedora para crear experiencias digitales únicas y funcionales. "Diseño Orquidea" 
                                es el resultado de este compromiso con la excelencia y la creatividad.
                            </p>
                        </div>
                    </div>

                    <hr class="my-5 opacity-10">

                    <div class="text-center">
                        <a href="{{ route('welcome') }}" class="btn btn-dark px-5 py-3 rounded-pill fw-bold">
                            <i class="bi bi-shop me-2"></i>Volver a la Tienda
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted small">© {{ date('Y') }} DISEÑO ORQUIDEA - Todos los derechos reservados</p>
            </div>
        </div>
    </div>
</div>
@endsection
