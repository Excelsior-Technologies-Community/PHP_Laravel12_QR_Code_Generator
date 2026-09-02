<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Open Graph meta tags for WhatsApp/social share preview --}}
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:description" content="{{ $product->description ?? 'Check out this product!' }}">
    <meta property="og:url" content="{{ route('products.show', $product->id) }}">
    <meta property="og:type" content="product">
</head>
<body class="bg-light">
<div class="container py-5">
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mb-4">← Back to Products</a>

    <div class="row g-4">
        {{-- Product Info --}}
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-body">
                    <h2 class="card-title">{{ $product->name }}</h2>
                    <p class="text-muted">{{ $product->description ?? 'No description provided.' }}</p>
                    <h3 class="text-success fw-bold">₹{{ number_format($product->price, 2) }}</h3>
                    <hr>
                    <p class="text-muted small mb-1">Product ID: #{{ $product->id }}</p>
                    <p class="text-muted small">Added: {{ $product->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        {{-- QR Code + Share --}}
        <div class="col-md-6">
            <div class="card shadow h-100 text-center">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">📱 Scan QR Code</h5>
                </div>
                <div class="card-body">
                    @if($product->qr_code && file_exists(public_path('qrcode/' . $product->qr_code)))
                        <img src="{{ asset('qrcode/' . $product->qr_code) }}"
                             alt="QR Code for {{ $product->name }}"
                             class="img-fluid mb-3"
                             style="max-width: 220px;">
                        <p class="text-muted small">Scan to open this product page</p>

                        {{-- Download QR --}}
                        <a href="{{ asset('qrcode/' . $product->qr_code) }}"
                           download="qr_{{ Str::slug($product->name) }}.svg"
                           class="btn btn-outline-dark btn-sm mb-3">
                            ⬇️ Download QR Code
                        </a>
                    @else
                        <p class="text-danger">QR Code not found.</p>
                    @endif

                    <hr>

                    {{-- Share Section --}}
                    <h6 class="fw-semibold mb-3">🔗 Share This Product</h6>

                    {{-- Copy Link --}}
                    <div class="input-group mb-3">
                        <input type="text" id="productUrl" class="form-control form-control-sm"
                               value="{{ route('products.show', $product->id) }}" readonly>
                        <button class="btn btn-outline-secondary btn-sm" onclick="copyLink()">Copy</button>
                    </div>

                    {{-- Social Share Buttons --}}
                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        {{-- WhatsApp --}}
                        <a href="https://wa.me/?text={{ urlencode($product->name . ' - ₹' . $product->price . ' | ' . route('products.show', $product->id)) }}"
                           target="_blank" class="btn btn-success btn-sm">
                            💬 WhatsApp
                        </a>

                        {{-- Facebook --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('products.show', $product->id)) }}"
                           target="_blank" class="btn btn-primary btn-sm">
                            📘 Facebook
                        </a>

                        {{-- Twitter/X --}}
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($product->name . ' - ₹' . $product->price) }}&url={{ urlencode(route('products.show', $product->id)) }}"
                           target="_blank" class="btn btn-info btn-sm text-white">
                            🐦 Twitter
                        </a>

                        {{-- Telegram --}}
                        <a href="https://t.me/share/url?url={{ urlencode(route('products.show', $product->id)) }}&text={{ urlencode($product->name . ' - ₹' . $product->price) }}"
                           target="_blank" class="btn btn-secondary btn-sm">
                            ✈️ Telegram
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyLink() {
    const input = document.getElementById('productUrl');
    input.select();
    navigator.clipboard.writeText(input.value).then(() => {
        alert('Link copied to clipboard!');
    });
}
</script>
</body>
</html>
