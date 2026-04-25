<x-layout>
    @section('css')
    <style>
        /* Container principal */
        .form-container {
            background: var(--color-cream);
            min-height: calc(100vh - 76px);
            padding: 2rem 0;
            margin: 0 -15px;
        }

        /* Card del formulario */
        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 900px;
            margin: 0 auto;
            border: 1px solid var(--color-border);
        }

        .form-header {
            background: #000000;
            color: #FFFFFF !important;
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .form-icon {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .form-header h1 {
            color: #FFFFFF !important;
            margin: 0;
            font-size: 1.9rem;
        }

        .form-header p {
            color: #FFFFFF !important;
            margin: 0.5rem 0 0;
            opacity: 0.8;
        }

        .form-body {
            padding: 2.5rem;
            background: white;
        }

        .section-title {
            color: #000000 !important;
            font-weight: 700;
            border-bottom: 2px solid #000000;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: #000000 !important;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            background-color: #FFFFFF !important;
            color: #000000 !important;
            border: 2px solid #000000 !important;
            border-radius: 10px;
            padding: 0.8rem;
        }

        .form-control::placeholder {
            color: #666666 !important;
            opacity: 1;
        }

        .input-group-text {
            background: #000000 !important;
            color: #FFFFFF !important;
            border: 2px solid #000000 !important;
        }

        .btn-save {
            background: #000000 !important;
            color: #FFFFFF !important;
            font-weight: 700;
            padding: 1rem 2rem;
            border-radius: 10px;
            border: none;
        }

        .btn-save:hover {
            background: #333333 !important;
        }

        .image-preview-section {
            background: #fdfdfd;
            border: 2px dashed #000000;
            border-radius: 15px;
            padding: 1.5rem;
        }
    </style>
    @endsection

    <div class="form-container">
        <div class="container">
            <div class="form-card">
                <!-- Header -->
                <div class="form-header">
                    <div class="form-icon">
                        <i class="bi bi-{{ isset($product) ? 'pencil-square' : 'plus-circle' }}"></i>
                    </div>
                    <div>
                        <h1>{{ isset($product) ? 'Editar' : 'Agregar' }} Producto</h1>
                        <p>{{ isset($product) ? 'Modifica la información del producto' : 'Completa el formulario para crear un nuevo producto' }}</p>
                    </div>
                </div>

                <!-- Body -->
                <div class="form-body">
                    <!-- Error Alert -->
                    @if ($errors->has('error'))
                        <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div>
                                <strong>Error:</strong> {{ $errors->first('error') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Formulario -->
                    <form method='POST'
                          action="{{ url('/products') }}"
                          class="needs-validation"
                          novalidate
                          enctype="multipart/form-data"
                          id="productForm">
                        @csrf
                        <input type="hidden" name="id" value="{{ isset($product) ? $product->id : '' }}">

                        <!-- Información Básica -->
                        <div class="form-section">
                        <h3 class="section-title">
                            <i class="bi bi-info-circle"></i> {{ __('Información Básica') }}
                        </h3>

                        <div class="row g-4">
                            <div class="col-md-8">
                                <label for="name" class="form-label">
                                    <i class="bi bi-tag"></i> {{ __('Nombre del Producto') }} <span class="required">*</span>
                                </label>
                                    <input name="name"
                                           type="text"
                                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                           id="name"
                                           value="{{ old('name', $product->name ?? '') }}"
                                           required
                                           maxlength="50"
                                           placeholder="Ej: Jabón Artesanal de Lavanda">
                                    <div class="char-counter">
                                        <span id="nameCount">0</span>/50 caracteres
                                    </div>
                                    @if($errors->has('name'))
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-x-circle"></i>
                                            {{ $errors->first('name') }}
                                        </div>
                                    @else
                                        <div class="invalid-feedback">
                                            <i class="bi bi-x-circle"></i>
                                            Por favor, ingresa un nombre válido (máx. 50 caracteres)
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label for="price" class="form-label">
                                    <i class="bi bi-currency-dollar"></i> {{ __('Precio') }} <span class="required">*</span>
                                </label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text">$</span>
                                        <input name="price"
                                               type="number"
                                               min="0.01"
                                               step=".01"
                                               max="9999999"
                                               class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}"
                                               value="{{ old('price', $product->price ?? '') }}"
                                               id="price"
                                               required
                                               placeholder="0.00">
                                        @if($errors->has('price'))
                                            <div class="invalid-feedback d-block">
                                                <i class="bi bi-x-circle"></i>
                                                {{ $errors->first('price') }}
                                            </div>
                                        @else
                                            <div class="invalid-feedback">
                                                <i class="bi bi-x-circle"></i>
                                                Ingresa un precio válido
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="category" class="form-label">
                                    <i class="bi bi-grid"></i> {{ __('Categoría') }} <span class="required">*</span>
                                </label>
                                    <select name="category" id="category" class="form-select {{ $errors->has('category') ? 'is-invalid' : '' }}">
                                        <option value="">Seleccionar categoría (Opcional)</option>
                                        <option value="Jabones" {{ old('category', $product->category ?? '') == 'Jabones' ? 'selected' : '' }}>Jabones</option>
                                        <option value="Mascarillas en polvo" {{ old('category', $product->category ?? '') == 'Mascarillas en polvo' ? 'selected' : '' }}>Mascarillas en polvo</option>
                                        <option value="Bálsamos" {{ old('category', $product->category ?? '') == 'Bálsamos' ? 'selected' : '' }}>Bálsamos</option>
                                        <option value="Cremas faciales" {{ old('category', $product->category ?? '') == 'Cremas faciales' ? 'selected' : '' }}>Cremas faciales</option>
                                        <option value="Cremas corporales" {{ old('category', $product->category ?? '') == 'Cremas corporales' ? 'selected' : '' }}>Cremas corporales</option>
                                    </select>
                                    @if($errors->has('category'))
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-x-circle"></i>
                                            {{ $errors->first('category') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label for="stock" class="form-label">
                                        <i class="bi bi-box-seam"></i> {{ __('Cantidad en Stock') }} <span class="required">*</span>
                                    </label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                        <input name="stock"
                                               type="number"
                                               min="0"
                                               max="99999"
                                               class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}"
                                               value="{{ old('stock', $product->stock ?? 0) }}"
                                               id="stock"
                                               required
                                               placeholder="0">
                                        @if($errors->has('stock'))
                                            <div class="invalid-feedback d-block">
                                                <i class="bi bi-x-circle"></i>
                                                {{ $errors->first('stock') }}
                                            </div>
                                        @else
                                            <div class="invalid-feedback">
                                                <i class="bi bi-x-circle"></i>
                                                Ingresa una cantidad de stock válida
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12">
                                    <h3 class="section-title">
                            <i class="bi bi-text-left"></i> {{ __('Descripción Detallada') }}
                        </h3>

                        <div class="form-group mb-4">
                            <label for="description" class="form-label">
                                <i class="bi bi-body-text"></i> {{ __('Descripción') }}
                            </label>
                                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                              name="description"
                                              id="description"
                                              rows="4"
                                              required
                                              maxlength="100"
                                              placeholder="Describe las características principales del producto...">{{ old('description', $product->description ?? '') }}</textarea>
                                    <div class="char-counter">
                                        <span id="descCount">0</span>/100 caracteres
                                    </div>
                                    @if($errors->has('description'))
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-x-circle"></i>
                                            {{ $errors->first('description') }}
                                        </div>
                                    @else
                                        <div class="invalid-feedback">
                                            <i class="bi bi-x-circle"></i>
                                            La descripción es requerida (máx. 100 caracteres)
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Imagen del Producto -->
                        <div class="form-section">
                            <div class="section-title">
                                <i class="bi bi-image-fill"></i>
                                <span>Imagen del Producto</span>
                            </div>

                            <div class="image-preview-section">
                                <x-image-dropzone
                                    name="image"
                                    :current-image="isset($product) && $product->hasImage() ? $product->image_url : null"
                                    :current-image-alt="isset($product) ? $product->name : ''"
                                    :error="$errors->first('image')"
                                    currentimageclass="col-12 col-md-5"
                                    dropzoneclass="col-12 col-md-7"
                                    title="Arrastra tu imagen aquí"
                                    subtitle="o haz clic para seleccionar"
                                    help-text="Formatos permitidos: JPG, PNG, GIF, SVG, WEBP (máx. 5MB)"
                                    :max-size="5"
                                    :show-current-image="true"
                                    dropzone-height="220px"
                                />
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="btn-group-custom">
                    <button type="submit" class="btn-custom btn-save" id="submitBtn">
                        <i class="bi bi-check-circle"></i> {{ __('Publicar Producto') }}
                    </button>
                    <a href="{{ route('products.index') }}" class="btn-custom btn-secondary" style="background: #e0e6ed; color: #4a5568; box-shadow: none;">
                        <i class="bi bi-x-circle"></i> {{ __('Cancelar') }}
                    </a>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('styles')
        {{-- Estilos de componentes --}}
        @stack('styles')
    @endsection

    @section('js')
        <script>
            (function() {
                'use strict';

                const form = document.getElementById('productForm');
                const submitButton = document.getElementById('submitBtn');
                const nameInput = document.getElementById('name');
                const descInput = document.getElementById('description');
                const nameCounter = document.getElementById('nameCount');
                const descCounter = document.getElementById('descCount');

                if (!form || !submitButton) return;

                const originalButtonText = submitButton.innerHTML;
                let isSubmitting = false;

                // Character counters
                function updateCounter(input, counter, max) {
                    const length = input.value.length;
                    counter.textContent = length;

                    // Update parent element class for color
                    const parent = counter.parentElement;
                    parent.classList.remove('warning', 'danger');

                    if (length > max * 0.9) {
                        parent.classList.add('danger');
                    } else if (length > max * 0.7) {
                        parent.classList.add('warning');
                    }
                }

                if (nameInput && nameCounter) {
                    updateCounter(nameInput, nameCounter, 50);
                    nameInput.addEventListener('input', function() {
                        updateCounter(this, nameCounter, 50);
                    });
                }

                if (descInput && descCounter) {
                    updateCounter(descInput, descCounter, 100);
                    descInput.addEventListener('input', function() {
                        updateCounter(this, descCounter, 100);
                    });
                }

                // Form validation and submission
                form.addEventListener('submit', function(event) {
                    // Validate form
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                        form.classList.add('was-validated');

                        // Scroll to first invalid field
                        const firstInvalid = form.querySelector(':invalid');
                        if (firstInvalid) {
                            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            firstInvalid.focus();
                        }
                        return false;
                    }

                    // Prevent multiple submissions
                    if (isSubmitting) {
                        event.preventDefault();
                        return false;
                    }

                    // Mark as submitting
                    isSubmitting = true;

                    // Disable button and show loading state
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Guardando...';

                    form.classList.add('was-validated');

                    // Reset if stays on page (validation errors)
                    setTimeout(function() {
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalButtonText;
                        isSubmitting = false;
                    }, 3000);
                }, false);

                // Real-time validation feedback
                const inputs = form.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    input.addEventListener('blur', function() {
                        if (this.checkValidity()) {
                            this.classList.add('is-valid');
                            this.classList.remove('is-invalid');
                        } else if (this.value) {
                            this.classList.add('is-invalid');
                            this.classList.remove('is-valid');
                        }
                    });

                    input.addEventListener('input', function() {
                        if (form.classList.contains('was-validated')) {
                            if (this.checkValidity()) {
                                this.classList.add('is-valid');
                                this.classList.remove('is-invalid');
                            } else {
                                this.classList.add('is-invalid');
                                this.classList.remove('is-valid');
                            }
                        }
                    });
                });

                // Price formatting
                const priceInput = document.getElementById('price');
                if (priceInput) {
                    priceInput.addEventListener('blur', function() {
                        if (this.value) {
                            const value = parseFloat(this.value);
                            if (!isNaN(value)) {
                                this.value = value.toFixed(2);
                            }
                        }
                    });
                }

                // Confirm navigation if form has changes
                let formChanged = false;
                inputs.forEach(input => {
                    input.addEventListener('change', function() {
                        formChanged = true;
                    });
                });

                window.addEventListener('beforeunload', function(e) {
                    if (formChanged && !isSubmitting) {
                        e.preventDefault();
                        e.returnValue = '';
                    }
                });

                // Clear flag on successful submit
                form.addEventListener('submit', function() {
                    formChanged = false;
                });
            })();
        </script>

        {{-- Scripts de componentes --}}
        @stack('scripts')
    @endsection
</x-layout>
