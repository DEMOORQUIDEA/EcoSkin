<x-layout>
    @section('css')
    <style>
        /* Container principal */
        .form-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: calc(100vh - 76px);
            padding: 2rem 0;
            margin: 0 -15px;
        }

        /* Card del formulario */
        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            max-width: 900px;
            margin: 0 auto;
        }

        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .form-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .form-icon i {
            font-size: 2rem;
        }

        .form-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }

        .form-header p {
            margin: 0.5rem 0 0;
            opacity: 0.9;
            font-size: 1rem;
        }

        /* Form body */
        .form-body {
            padding: 2.5rem;
        }

        /* Alert styles */
        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 1.25rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .alert-custom i {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        /* Form sections */
        .form-section {
            margin-bottom: 2rem;
        }

        .section-title {
            color: #2d3748;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e0e6ed;
        }

        .section-title i {
            color: #667eea;
            font-size: 1.3rem;
        }

        /* Form controls */
        .form-label {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: #667eea;
        }

        .form-label .required {
            color: #f5576c;
            margin-left: 0.25rem;
        }

        .form-control,
        .form-select {
            border: 2px solid #e0e6ed;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
            background: white;
            outline: none;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #f5576c;
            background: #fff5f7;
        }

        .form-control.is-invalid:focus,
        .form-select.is-invalid:focus {
            box-shadow: 0 0 0 0.2rem rgba(245, 87, 108, 0.15);
        }

        .invalid-feedback {
            color: #f5576c;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .invalid-feedback i {
            font-size: 1rem;
        }

        /* Input group */
        .input-group {
            border-radius: 12px;
            overflow: hidden;
        }

        .input-group-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 0.875rem 1rem;
        }

        .input-group .form-control {
            border-radius: 0 12px 12px 0;
            border-left: none;
        }

        /* Textarea */
        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        /* Character counter */
        .char-counter {
            font-size: 0.85rem;
            color: #718096;
            margin-top: 0.5rem;
            text-align: right;
        }

        .char-counter.warning {
            color: #ffc107;
            font-weight: 600;
        }

        .char-counter.danger {
            color: #f5576c;
            font-weight: 600;
        }

        /* Buttons */
        .btn-group-custom {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            padding-top: 2rem;
            border-top: 2px solid #e0e6ed;
        }

        .btn-custom {
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-save {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
        }

        .btn-save:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
            color: white;
        }

        .btn-custom i {
            font-size: 1.1rem;
        }

        /* Spinner */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.15em;
        }

        /* Image preview section */
        .image-preview-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            border: 2px dashed #e0e6ed;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 1rem 0;
            }

            .form-header {
                flex-direction: column;
                text-align: center;
                padding: 1.5rem;
            }

            .form-header h1 {
                font-size: 1.5rem;
            }

            .form-body {
                padding: 1.5rem;
            }

            .btn-group-custom {
                flex-direction: column;
            }

            .btn-custom {
                width: 100%;
                justify-content: center;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-card {
            animation: fadeIn 0.5s ease;
        }

        /* Success state */
        .form-control.is-valid {
            border-color: #28a745;
            background: #f0fff4;
        }

        .form-control.is-valid:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
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
                            <div class="section-title">
                                <i class="bi bi-info-circle-fill"></i>
                                <span>Información Básica</span>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-8">
                                    <label for="name" class="form-label">
                                        <i class="bi bi-tag"></i>
                                        Nombre del Producto
                                        <span class="required">*</span>
                                    </label>
                                    <input name="name"
                                           type="text"
                                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                           id="name"
                                           value="{{ old('name', $product->name ?? '') }}"
                                           required
                                           maxlength="50"
                                           placeholder="Ej: Laptop Dell XPS 15">
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

                                <div class="col-md-4">
                                    <label for="price" class="form-label">
                                        <i class="bi bi-cash"></i>
                                        Precio
                                        <span class="required">*</span>
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

                                <div class="col-12">
                                    <label for="description" class="form-label">
                                        <i class="bi bi-file-text"></i>
                                        Descripción
                                        <span class="required">*</span>
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
                            <button class="btn btn-custom btn-save" type="submit" id="submitBtn">
                                <i class="bi bi-check-circle"></i>
                                <span>{{ isset($product) ? 'Actualizar' : 'Guardar' }} Producto</span>
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-custom btn-cancel">
                                <i class="bi bi-x-circle"></i>
                                <span>Cancelar</span>
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
