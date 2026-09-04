<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Products</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            color: #212529;
        }

        .page-header {
            background: linear-gradient(135deg, #111827, #1f2937);
            border-radius: 20px;
            padding: 28px;
            color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .page-header h2 {
            font-weight: 700;
            margin-bottom: 6px;
        }

        .page-header p {
            color: rgba(255, 255, 255, 0.7);
        }

        .stat-card {
            border: 0;
            border-radius: 18px;
            background: white;
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(15, 23, 42, 0.10);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .icon-blue {
            background: #e8f1ff;
        }

        .icon-green {
            background: #e8f8ef;
        }

        .icon-red {
            background: #fff0f0;
        }

        .icon-purple {
            background: #f1eaff;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            line-height: 1;
        }

        .filter-card {
            border: 0;
            border-radius: 18px;
            background: white;
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
        }

        .filter-input,
        .filter-select {
            height: 46px;
            border-radius: 12px;
            border: 1px solid #dee2e6;
        }

        .filter-input:focus,
        .filter-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.10);
        }

        .product-card {
            border: 0;
            border-radius: 18px;
            background: white;
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
            overflow: hidden;
            height: 100%;
            transition: all 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.11);
        }

        .product-card .card-body {
            padding: 22px;
        }

        .product-name {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 0;
        }

        .product-description {
            min-height: 48px;
            line-height: 1.5;
        }

        .price {
            font-size: 22px;
            font-weight: 700;
            color: #198754;
        }

        .status-badge {
            border-radius: 999px;
            padding: 6px 11px;
            font-size: 12px;
            font-weight: 600;
        }

        .qr-badge {
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 12px;
        }

        .product-footer {
            background: #fafbfc;
            border-top: 1px solid #eef0f3;
            padding: 14px 18px;
        }

        .action-btn {
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
        }

        .pagination {
            gap: 7px;
        }

        .pagination .page-item {
            margin: 0;
        }

        .pagination .page-link {
            border: 0;
            width: 40px;
            height: 40px;
            border-radius: 10px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #374151;
            background: white;
            font-weight: 600;
            box-shadow: 0 3px 10px rgba(15, 23, 42, 0.06);
        }

        .pagination .page-link:hover {
            background: #e9f2ff;
            color: #0d6efd;
        }

        .pagination .page-item.active .page-link {
            background: #0d6efd;
            color: white;
            box-shadow: 0 5px 14px rgba(13, 110, 253, 0.25);
        }

        .empty-state {
            border: 0;
            border-radius: 18px;
            background: white;
            padding: 60px 20px;
            text-align: center;
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
        }

        .empty-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            background: #eef4ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 32px;
        }

        .results-info {
            font-size: 13px;
            color: #6c757d;
        }

        @media (max-width: 767px) {

            .page-header {
                padding: 22px;
            }

            .page-header .header-actions {
                margin-top: 18px;
            }

            .stat-number {
                font-size: 24px;
            }

        }
    </style>

</head>

<body>

    <div class="container py-4 py-md-5">

        {{-- ============================================================
         HEADER
    ============================================================= --}}

        <div class="page-header mb-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">

                <div>

                    <h2>
                        🛍️ Products
                    </h2>

                    <p class="mb-0">
                        Manage your products and QR codes
                    </p>

                </div>

                <div class="header-actions d-flex gap-2">

                    <a
                        href="{{ route('products.analytics') }}"
                        class="btn btn-light px-3">

                        📊 Analytics

                    </a>

                    <a
                        href="{{ route('products.create') }}"
                        class="btn btn-primary px-3">

                        + Add Product

                    </a>

                </div>

            </div>

        </div>


        {{-- ============================================================
         SUCCESS MESSAGE
    ============================================================= --}}

        @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm">

            <strong>Success!</strong>
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

        @endif


        {{-- ============================================================
         ERROR MESSAGE
    ============================================================= --}}

        @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm">

            <strong>Error!</strong>
            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

        @endif


        {{-- ============================================================
         STATISTICS
    ============================================================= --}}

        <div class="row g-3 mb-4">

            {{-- TOTAL --}}

            <div class="col-6 col-lg-3">

                <div class="card stat-card h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="text-muted small mb-2">
                                    Total Products
                                </div>

                                <div class="stat-number">
                                    {{ $totalProducts }}
                                </div>

                            </div>

                            <div class="stat-icon icon-blue">
                                🛍️
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ACTIVE --}}

            <div class="col-6 col-lg-3">

                <div class="card stat-card h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="text-muted small mb-2">
                                    Active
                                </div>

                                <div class="stat-number text-success">
                                    {{ $activeProducts }}
                                </div>

                            </div>

                            <div class="stat-icon icon-green">
                                ✓
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- INACTIVE --}}

            <div class="col-6 col-lg-3">

                <div class="card stat-card h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="text-muted small mb-2">
                                    Inactive
                                </div>

                                <div class="stat-number text-danger">
                                    {{ $inactiveProducts }}
                                </div>

                            </div>

                            <div class="stat-icon icon-red">
                                ⏸
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- QR SCANS --}}

            <div class="col-6 col-lg-3">

                <div class="card stat-card h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="text-muted small mb-2">
                                    Total QR Scans
                                </div>

                                <div class="stat-number text-primary">
                                    {{ $totalScans }}
                                </div>

                            </div>

                            <div class="stat-icon icon-purple">
                                📱
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================
         SEARCH + FILTER
    ============================================================= --}}

        <div class="card filter-card mb-4">

            <div class="card-body p-3 p-md-4">

                <form
                    method="GET"
                    action="{{ route('products.index') }}">

                    <div class="row g-2">

                        {{-- SEARCH --}}

                        <div class="col-md-7">

                            <label class="form-label small fw-semibold text-muted">
                                Search Products
                            </label>

                            <input
                                type="text"
                                name="search"
                                class="form-control filter-input"
                                value="{{ request('search') }}"
                                placeholder="🔎 Search product name or description...">

                        </div>


                        {{-- STATUS --}}

                        <div class="col-md-3">

                            <label class="form-label small fw-semibold text-muted">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select filter-select">

                                <option value="">
                                    All Status
                                </option>

                                <option
                                    value="active"
                                    {{ request('status') === 'active' ? 'selected' : '' }}>

                                    Active

                                </option>

                                <option
                                    value="inactive"
                                    {{ request('status') === 'inactive' ? 'selected' : '' }}>

                                    Inactive

                                </option>

                            </select>

                        </div>


                        {{-- BUTTON --}}

                        <div class="col-md-2">

                            <label class="form-label small fw-semibold text-muted">
                                &nbsp;
                            </label>

                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                                style="height:46px; border-radius:12px;">

                                🔎 Search

                            </button>

                        </div>

                    </div>

                </form>


                {{-- ACTIVE FILTER INFO --}}

                @if(request('search') || request('status'))

                <div class="mt-3 d-flex align-items-center justify-content-between">

                    <div class="results-info">

                        Showing filtered results

                    </div>

                    <a
                        href="{{ route('products.index') }}"
                        class="btn btn-sm btn-outline-secondary">

                        Clear Filters

                    </a>

                </div>

                @endif

            </div>

        </div>


        {{-- ============================================================
         PRODUCTS
    ============================================================= --}}

        @if($products->isEmpty())

        {{-- EMPTY STATE --}}

        <div class="empty-state">

            <div class="empty-icon">
                🛍️
            </div>

            <h4 class="fw-bold">
                No products found
            </h4>

            <p class="text-muted mb-4">
                There are no products matching your current search or filter.
            </p>

            @if(request('search') || request('status'))

            <a
                href="{{ route('products.index') }}"
                class="btn btn-outline-primary">

                Clear Filters

            </a>

            @else

            <a
                href="{{ route('products.create') }}"
                class="btn btn-primary">

                + Add Your First Product

            </a>

            @endif

        </div>

        @else

        {{-- RESULTS COUNT --}}

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h5 class="fw-bold mb-0">
                    Product List
                </h5>

                <small class="text-muted">
                    {{ $products->total() }} product{{ $products->total() != 1 ? 's' : '' }} found
                </small>

            </div>

            <div class="results-info">

                Page {{ $products->currentPage() }}
                of {{ $products->lastPage() }}

            </div>

        </div>


        {{-- PRODUCT CARDS --}}

        <div class="row g-4">

            @foreach($products as $product)

            <div class="col-md-6 col-lg-4">

                <div class="card product-card">

                    {{-- CARD BODY --}}

                    <div class="card-body">

                        {{-- NAME + STATUS --}}

                        <div class="d-flex justify-content-between align-items-start gap-2 mb-3">

                            <h5 class="product-name">

                                {{ $product->name }}

                            </h5>

                            @if($product->status === 'active')

                            <span class="badge bg-success status-badge">
                                Active
                            </span>

                            @else

                            <span class="badge bg-danger status-badge">
                                Inactive
                            </span>

                            @endif

                        </div>


                        {{-- DESCRIPTION --}}

                        <p class="text-muted small product-description mb-3">

                            {{ Str::limit(
                                    $product->description,
                                    80
                                ) }}

                        </p>


                        {{-- PRICE --}}

                        <div class="price mb-3">

                            ₹{{ number_format(
                                    $product->price,
                                    2
                                ) }}

                        </div>


                        {{-- QR INFO --}}

                        <div class="d-flex gap-2 flex-wrap">

                            <span class="badge bg-dark qr-badge">

                                📱 QR Enabled

                            </span>

                            <span class="badge bg-secondary qr-badge">

                                {{ $product->qr_size }}px

                            </span>

                        </div>

                    </div>


                    {{-- CARD FOOTER --}}

                    <div class="product-footer">

                        <div class="d-flex gap-2 flex-wrap">

                            {{-- VIEW --}}

                            <a
                                href="{{ route(
                                        'products.show',
                                        $product->id
                                    ) }}"
                                class="btn btn-sm btn-outline-primary action-btn">

                                View & QR

                            </a>


                            {{-- EDIT --}}

                            <a
                                href="{{ route(
                                        'products.edit',
                                        $product->id
                                    ) }}"
                                class="btn btn-sm btn-outline-warning action-btn">

                                ✏️ Edit

                            </a>


                            {{-- REGENERATE QR --}}

                            <form
                                action="{{ route(
                                        'products.regenerate-qr',
                                        $product->id
                                    ) }}"
                                method="POST">

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-outline-success action-btn"
                                    title="Regenerate QR">

                                    🔄

                                </button>

                            </form>


                            {{-- TOGGLE STATUS --}}

                            <form
                                action="{{ route(
                                        'products.toggle-status',
                                        $product->id
                                    ) }}"
                                method="POST">

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-outline-secondary action-btn">

                                    {{ $product->status === 'active'
                                            ? 'Disable'
                                            : 'Enable'
                                        }}

                                </button>

                            </form>


                            {{-- DELETE --}}

                            <form
                                action="{{ route(
                                        'products.destroy',
                                        $product->id
                                    ) }}"
                                method="POST"
                                onsubmit="return confirm(
                                        'Delete this product and all scan history?'
                                    )">

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-outline-danger action-btn">

                                    Delete

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

            @endforeach

        </div>


        {{-- ========================================================
             NUMERIC PAGINATION ONLY
        ========================================================= --}}

        @if($products->hasPages())

        <div class="d-flex justify-content-center mt-5">

            <nav aria-label="Products pagination">

                <ul class="pagination mb-0">

                    @for(
                    $page = 1;
                    $page <= $products->lastPage();
                        $page++
                        )

                        <li class="page-item
                                {{ $page == $products->currentPage() ? 'active' : '' }}">

                            <a
                                class="page-link"
                                href="{{ $products->appends(
                                        request()->query()
                                    )->url($page) }}">

                                {{ $page }}

                            </a>

                        </li>

                        @endfor

                </ul>

            </nav>

        </div>

        @endif

        @endif

    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>
