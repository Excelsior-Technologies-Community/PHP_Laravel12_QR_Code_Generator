<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit {{ $product->name }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow">

                <div class="card-header bg-warning">

                    <h5 class="mb-0">
                        ✏️ Edit Product & QR Code
                    </h5>

                </div>

                <div class="card-body">

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form
                        action="{{ route('products.update', $product->id) }}"
                        method="POST"
                    >

                        @csrf

                        @method('PUT')

                        <div class="row">

                            <div class="col-md-8">

                                <div class="mb-3">

                                    <label class="form-label fw-semibold">
                                        Product Name *
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        value="{{ old('name', $product->name) }}"
                                        required
                                    >

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label class="form-label fw-semibold">
                                        Price (₹) *
                                    </label>

                                    <input
                                        type="number"
                                        name="price"
                                        class="form-control"
                                        value="{{ old('price', $product->price) }}"
                                        step="0.01"
                                        min="0"
                                        required
                                    >

                                </div>

                            </div>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Description
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="4"
                            >{{ old('description', $product->description) }}</textarea>

                        </div>

                        <hr>

                        <h5 class="mb-3">
                            🎨 Customize QR Code
                        </h5>

                        <div class="row">

                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    Foreground
                                </label>

                                <input
                                    type="color"
                                    name="qr_foreground_color"
                                    class="form-control form-control-color w-100"
                                    value="{{ old(
                                        'qr_foreground_color',
                                        $product->qr_foreground_color ?? '#000000'
                                    ) }}"
                                >

                            </div>

                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    Background
                                </label>

                                <input
                                    type="color"
                                    name="qr_background_color"
                                    class="form-control form-control-color w-100"
                                    value="{{ old(
                                        'qr_background_color',
                                        $product->qr_background_color ?? '#ffffff'
                                    ) }}"
                                >

                            </div>

                            <div class="col-md-4">

                                <label class="form-label fw-semibold">
                                    QR Size
                                </label>

                                <select
                                    name="qr_size"
                                    class="form-select"
                                >

                                    @foreach([200, 300, 400, 500, 600, 800, 1000] as $size)

                                        <option
                                            value="{{ $size }}"
                                            {{ (int) old(
                                                'qr_size',
                                                $product->qr_size ?? 300
                                            ) === $size ? 'selected' : '' }}
                                        >
                                            {{ $size }} × {{ $size }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                        <div class="alert alert-warning mt-4">

                            ⚠️ Saving this form will regenerate the product QR
                            code using the selected customization.

                        </div>

                        <div class="d-flex gap-2 mt-4">

                            <button
                                type="submit"
                                class="btn btn-warning"
                            >
                                💾 Update & Regenerate QR
                            </button>

                            <a
                                href="{{ route('products.show', $product->id) }}"
                                class="btn btn-secondary"
                            >
                                Cancel
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>