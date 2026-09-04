<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $product->name }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <meta
        property="og:title"
        content="{{ $product->name }}"
    >

    <meta
        property="og:description"
        content="{{ $product->description ?? 'Check out this product!' }}"
    >

    <meta
        property="og:url"
        content="{{ route('products.show', $product->id) }}"
    >

    <meta
        property="og:type"
        content="product"
    >

    <style>

        body {
            min-height: 100vh;
        }

        .stat-card {
            border: none;
            transition: transform .2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .qr-wrapper {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
        }

        .qr-image {
            max-width: 300px;
            width: 100%;
            height: auto;
        }

    </style>

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <a
            href="{{ route('products.index') }}"
            class="btn btn-outline-secondary"
        >
            ← Back to Products
        </a>

        <a
            href="{{ route('products.edit', $product->id) }}"
            class="btn btn-warning"
        >
            ✏️ Edit Product
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

    {{-- Product + QR --}}

    <div class="row g-4">

        {{-- Product Information --}}

        <div class="col-lg-6">

            <div class="card shadow h-100">

                <div class="card-body p-4">

                    <span class="badge bg-primary mb-3">
                        Product #{{ $product->id }}
                    </span>

                    <h2 class="card-title">
                        {{ $product->name }}
                    </h2>

                    <p class="text-muted mt-3">
                        {{ $product->description ?? 'No description provided.' }}
                    </p>

                    <h3 class="text-success fw-bold mt-4">
                        ₹{{ number_format($product->price, 2) }}
                    </h3>

                    <hr>

                    <div class="row">

                        <div class="col-sm-6">

                            <p class="text-muted small mb-1">
                                Added
                            </p>

                            <strong>
                                {{ $product->created_at->format('d M Y') }}
                            </strong>

                        </div>

                        <div class="col-sm-6">

                            <p class="text-muted small mb-1">
                                QR Size
                            </p>

                            <strong>
                                {{ $product->qr_size ?? 300 }} ×
                                {{ $product->qr_size ?? 300 }}
                            </strong>

                        </div>

                    </div>

                    <div class="mt-4">

                        <p class="text-muted small mb-1">
                            QR Colors
                        </p>

                        <div class="d-flex gap-3 align-items-center">

                            <div>

                                <span
                                    class="d-inline-block rounded-circle border"
                                    style="
                                        width: 30px;
                                        height: 30px;
                                        background: {{ $product->qr_foreground_color ?? '#000000' }};
                                    "
                                ></span>

                                <small>
                                    Foreground
                                </small>

                            </div>

                            <div>

                                <span
                                    class="d-inline-block rounded-circle border"
                                    style="
                                        width: 30px;
                                        height: 30px;
                                        background: {{ $product->qr_background_color ?? '#ffffff' }};
                                    "
                                ></span>

                                <small>
                                    Background
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- QR Code --}}

        <div class="col-lg-6">

            <div class="card shadow h-100 text-center">

                <div class="card-header bg-dark text-white">

                    <h5 class="mb-0">
                        📱 Product QR Code
                    </h5>

                </div>

                <div class="card-body p-4">

                    @if(
                        $product->qr_code &&
                        file_exists(public_path('qrcode/' . $product->qr_code))
                    )

                        <div class="qr-wrapper mb-3">

                            <img
                                src="{{ asset('qrcode/' . $product->qr_code) }}"
                                alt="QR Code for {{ $product->name }}"
                                class="img-fluid qr-image"
                            >

                        </div>

                        <p class="text-muted small">
                            Scan this QR code to open the product page.
                        </p>

                        <div class="d-flex justify-content-center gap-2 flex-wrap">

                            <a
                                href="{{ asset('qrcode/' . $product->qr_code) }}"
                                download="qr_{{ Str::slug($product->name) }}.svg"
                                class="btn btn-dark"
                            >
                                ⬇️ Download QR
                            </a>

                            <form
                                action="{{ route('products.regenerate-qr', $product->id) }}"
                                method="POST"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-success"
                                >
                                    🔄 Regenerate QR
                                </button>

                            </form>

                        </div>

                    @else

                        <div class="alert alert-danger">
                            QR Code not found.
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

    {{-- Analytics --}}

    <div class="mt-5">

        <h4 class="mb-3">
            📊 QR Scan Analytics
        </h4>

        <div class="row g-3">

            <div class="col-md-4">

                <div class="card shadow-sm stat-card">

                    <div class="card-body text-center">

                        <div class="fs-2">
                            📱
                        </div>

                        <h6 class="text-muted">
                            Total Scans
                        </h6>

                        <h2 class="fw-bold">
                            {{ $totalScans }}
                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow-sm stat-card">

                    <div class="card-body text-center">

                        <div class="fs-2">
                            📅
                        </div>

                        <h6 class="text-muted">
                            Today's Scans
                        </h6>

                        <h2 class="fw-bold">
                            {{ $todayScans }}
                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow-sm stat-card">

                    <div class="card-body text-center">

                        <div class="fs-2">
                            📈
                        </div>

                        <h6 class="text-muted">
                            This Week
                        </h6>

                        <h2 class="fw-bold">
                            {{ $weekScans }}
                        </h2>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Last Scan --}}

    <div class="card shadow-sm mt-4">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-6">

                    <h6 class="mb-1">
                        🕐 Last QR Scan
                    </h6>

                    @if($lastScan)

                        <strong>
                            {{ $lastScan->scanned_at->format('d M Y, h:i A') }}
                        </strong>

                    @else

                        <span class="text-muted">
                            No scans yet.
                        </span>

                    @endif

                </div>

                <div class="col-md-6 text-md-end">

                    @if($lastScan)

                        <span class="badge bg-primary">
                            {{ $lastScan->device }}
                        </span>

                        <span class="badge bg-secondary">
                            {{ $lastScan->browser }}
                        </span>

                        <span class="badge bg-dark">
                            {{ $lastScan->operating_system }}
                        </span>

                    @endif

                </div>

            </div>

        </div>

    </div>

    {{-- Share --}}

    <div class="card shadow-sm mt-4">

        <div class="card-body">

            <h5 class="mb-3">
                🔗 Share This Product
            </h5>

            <div class="input-group mb-3">

                <input
                    type="text"
                    id="productUrl"
                    class="form-control"
                    value="{{ route('products.show', $product->id) }}"
                    readonly
                >

                <button
                    class="btn btn-outline-secondary"
                    onclick="copyLink()"
                >
                    Copy
                </button>

            </div>

            <div class="d-flex flex-wrap gap-2">

                <a
                    href="https://wa.me/?text={{ urlencode(
                        $product->name .
                        ' - ₹' .
                        $product->price .
                        ' | ' .
                        route('products.show', $product->id)
                    ) }}"
                    target="_blank"
                    class="btn btn-success"
                >
                    💬 WhatsApp
                </a>

                <a
                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('products.show', $product->id)) }}"
                    target="_blank"
                    class="btn btn-primary"
                >
                    📘 Facebook
                </a>

                <a
                    href="https://twitter.com/intent/tweet?text={{ urlencode(
                        $product->name . ' - ₹' . $product->price
                    ) }}&url={{ urlencode(route('products.show', $product->id)) }}"
                    target="_blank"
                    class="btn btn-info text-white"
                >
                    🐦 Twitter/X
                </a>

                <a
                    href="https://t.me/share/url?url={{ urlencode(route('products.show', $product->id)) }}&text={{ urlencode($product->name . ' - ₹' . $product->price) }}"
                    target="_blank"
                    class="btn btn-secondary"
                >
                    ✈️ Telegram
                </a>

            </div>

        </div>

    </div>

    {{-- Scan History --}}

    <div class="card shadow-sm mt-4">

        <div class="card-header">

            <h5 class="mb-0">
                📋 Recent QR Scans
            </h5>

        </div>

        <div class="card-body p-0">

            @if($recentScans->isEmpty())

                <div class="p-4 text-center text-muted">

                    No QR scans recorded yet.

                </div>

            @else

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>
                                    Date & Time
                                </th>

                                <th>
                                    Device
                                </th>

                                <th>
                                    Browser
                                </th>

                                <th>
                                    OS
                                </th>

                                <th>
                                    IP
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($recentScans as $scan)

                                <tr>

                                    <td>
                                        {{ $scan->scanned_at->format('d M Y, h:i A') }}
                                    </td>

                                    <td>
                                        {{ $scan->device }}
                                    </td>

                                    <td>
                                        {{ $scan->browser }}
                                    </td>

                                    <td>
                                        {{ $scan->operating_system }}
                                    </td>

                                    <td>
                                        {{ $scan->ip_address }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>

</div>

<script>

function copyLink() {

    const input = document.getElementById('productUrl');

    navigator.clipboard.writeText(input.value)
        .then(() => {

            const button = event.target;

            const originalText = button.innerText;

            button.innerText = 'Copied!';

            setTimeout(() => {
                button.innerText = originalText;
            }, 1500);

        })
        .catch(() => {

            input.select();

            document.execCommand('copy');

            alert('Link copied to clipboard!');

        });
}

</script>

</body>
</html>