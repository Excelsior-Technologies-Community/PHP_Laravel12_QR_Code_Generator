<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Product</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-dark text-white py-3">
                        <h4 class="mb-0">✏️ Edit Product</h4>
                    </div>

                    <div class="card-body p-4">

                        {{-- Validation Errors --}}
                        @if ($errors->any())
                        <div class="alert alert-danger">

                            <strong>Please fix the following errors:</strong>

                            <ul class="mb-0 mt-2">

                                @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>
                        @endif


                        {{-- Success Message --}}
                        @if (session('success'))

                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>

                        @endif


                        <form
                            action="{{ route('products.update', $product) }}"
                            method="POST">

                            @csrf
                            @method('PUT')


                            {{-- Product Name --}}
                            <div class="mb-3">

                                <label
                                    for="name"
                                    class="form-label fw-semibold">
                                    Product Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $product->name) }}"
                                    placeholder="Enter product name"
                                    required>

                                @error('name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                                @enderror

                            </div>


                            {{-- Price --}}
                            <div class="mb-3">

                                <label
                                    for="price"
                                    class="form-label fw-semibold">
                                    Price
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        ₹
                                    </span>

                                    <input
                                        type="number"
                                        name="price"
                                        id="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price', $product->price) }}"
                                        placeholder="0.00"
                                        min="0"
                                        step="0.01"
                                        required>

                                </div>

                                @error('price')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                                @enderror

                            </div>


                            {{-- Description --}}
                            <div class="mb-3">

                                <label
                                    for="description"
                                    class="form-label fw-semibold">
                                    Description
                                </label>

                                <textarea
                                    name="description"
                                    id="description"
                                    rows="4"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>

                                @error('description')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                                @enderror

                            </div>


                            {{-- Product Status --}}
                            <div class="mb-3">

                                <label
                                    for="status"
                                    class="form-label fw-semibold">
                                    Product Status
                                </label>

                                <select
                                    name="status"
                                    id="status"
                                    class="form-select @error('status') is-invalid @enderror">

                                    <option
                                        value="active"
                                        {{ old('status', $product->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option
                                        value="inactive"
                                        {{ old('status', $product->status ?? 'active') === 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>

                                </select>

                                @error('status')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                                @enderror

                                <div class="form-text">
                                    Inactive products will not be available through their QR code.
                                </div>

                            </div>


                            <hr class="my-4">


                            <h5 class="mb-3">
                                🔳 QR Code Settings
                            </h5>


                            {{-- QR Foreground Color --}}
                            <div class="mb-3">

                                <label
                                    for="qr_foreground_color"
                                    class="form-label fw-semibold">
                                    QR Foreground Color
                                </label>

                                <div class="d-flex gap-2 align-items-center">

                                    <input
                                        type="color"
                                        id="qr_foreground_picker"
                                        class="form-control form-control-color"
                                        value="{{ old('qr_foreground_color', $product->qr_foreground_color ?? '#000000') }}">

                                    <input
                                        type="text"
                                        name="qr_foreground_color"
                                        id="qr_foreground_color"
                                        class="form-control @error('qr_foreground_color') is-invalid @enderror"
                                        value="{{ old('qr_foreground_color', $product->qr_foreground_color ?? '#000000') }}"
                                        placeholder="#000000">

                                </div>

                                @error('qr_foreground_color')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                                @enderror

                            </div>


                            {{-- QR Background Color --}}
                            <div class="mb-3">

                                <label
                                    for="qr_background_color"
                                    class="form-label fw-semibold">
                                    QR Background Color
                                </label>

                                <div class="d-flex gap-2 align-items-center">

                                    <input
                                        type="color"
                                        id="qr_background_picker"
                                        class="form-control form-control-color"
                                        value="{{ old('qr_background_color', $product->qr_background_color ?? '#ffffff') }}">

                                    <input
                                        type="text"
                                        name="qr_background_color"
                                        id="qr_background_color"
                                        class="form-control @error('qr_background_color') is-invalid @enderror"
                                        value="{{ old('qr_background_color', $product->qr_background_color ?? '#ffffff') }}"
                                        placeholder="#ffffff">

                                </div>

                                @error('qr_background_color')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                                @enderror

                            </div>


                            {{-- QR Size --}}
                            <div class="mb-3">

                                <label
                                    for="qr_size"
                                    class="form-label fw-semibold">
                                    QR Code Size
                                </label>

                                <select
                                    name="qr_size"
                                    id="qr_size"
                                    class="form-select @error('qr_size') is-invalid @enderror">

                                    @foreach ([200, 300, 400, 500, 600, 800, 1000] as $size)

                                    <option
                                        value="{{ $size }}"
                                        {{ old('qr_size', $product->qr_size ?? 300) == $size ? 'selected' : '' }}>
                                        {{ $size }} × {{ $size }} px
                                    </option>

                                    @endforeach

                                </select>

                                @error('qr_size')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                                @enderror

                            </div>


                            {{-- QR Expiration --}}
                            <div class="mb-4">

                                <label
                                    for="qr_expires_at"
                                    class="form-label fw-semibold">
                                    QR Code Expiration
                                </label>

                                <input
                                    type="datetime-local"
                                    name="qr_expires_at"
                                    id="qr_expires_at"
                                    class="form-control @error('qr_expires_at') is-invalid @enderror"
                                    value="{{ old(
                                    'qr_expires_at',
                                    $product->qr_expires_at
                                        ? $product->qr_expires_at->format('Y-m-d\TH:i')
                                        : ''
                                ) }}"
                                    min="{{ now()->format('Y-m-d\TH:i') }}">

                                @error('qr_expires_at')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                                @enderror

                                <div class="form-text">
                                    Leave empty if the QR code should never expire.
                                </div>

                            </div>


                            {{-- Warning --}}
                            <div class="alert alert-warning">

                                <strong>⚠️ Important:</strong>

                                Saving this product will regenerate its QR code
                                using the selected QR settings.

                            </div>


                            {{-- Buttons --}}
                            <div class="d-flex justify-content-between">

                                <a
                                    href="{{ route('products.show', $product) }}"
                                    class="btn btn-outline-secondary">
                                    ← Cancel
                                </a>

                                <button
                                    type="submit"
                                    class="btn btn-primary px-4">
                                    💾 Update Product
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <script>
        const foregroundPicker =
            document.getElementById('qr_foreground_picker');

        const foregroundInput =
            document.getElementById('qr_foreground_color');

        const backgroundPicker =
            document.getElementById('qr_background_picker');

        const backgroundInput =
            document.getElementById('qr_background_color');


        foregroundPicker.addEventListener('input', function() {

            foregroundInput.value = this.value;

        });


        foregroundInput.addEventListener('input', function() {

            if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {

                foregroundPicker.value = this.value;

            }

        });


        backgroundPicker.addEventListener('input', function() {

            backgroundInput.value = this.value;

        });


        backgroundInput.addEventListener('input', function() {

            if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {

                backgroundPicker.value = this.value;

            }

        });
    </script>

</body>

</html>