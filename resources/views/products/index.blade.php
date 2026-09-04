<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Products</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            🛍️ Products
        </h2>

        <a
            href="{{ route('products.create') }}"
            class="btn btn-primary"
        >
            + Add Product
        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif

    @if($products->isEmpty())

        <div class="alert alert-info">

            No products yet.
            Add your first product!

        </div>

    @else

        <div class="row g-4">

            @foreach($products as $product)

                <div class="col-md-4">

                    <div class="card shadow-sm h-100">

                        <div class="card-body">

                            <h5 class="card-title">
                                {{ $product->name }}
                            </h5>

                            <p class="text-muted small">
                                {{ Str::limit($product->description, 80) }}
                            </p>

                            <p class="fw-bold text-success fs-5">
                                ₹{{ number_format($product->price, 2) }}
                            </p>

                            <div class="d-flex gap-2 flex-wrap">

                                <span class="badge bg-dark">
                                    📱 QR Enabled
                                </span>

                            </div>

                        </div>

                        <div class="card-footer">

                            <div class="d-flex gap-2 flex-wrap">

                                <a
                                    href="{{ route('products.show', $product->id) }}"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    View & QR
                                </a>

                                <a
                                    href="{{ route('products.edit', $product->id) }}"
                                    class="btn btn-sm btn-outline-warning"
                                >
                                    ✏️ Edit
                                </a>

                                <form
                                    action="{{ route('products.regenerate-qr', $product->id) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline-success"
                                    >
                                        🔄 Regenerate
                                    </button>

                                </form>

                                <form
                                    action="{{ route('products.destroy', $product->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this product and its QR code?')"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
></script>

</body>
</html>