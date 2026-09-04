<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>QR Analytics Dashboard</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            color: #1f2937;
        }

        /* =========================================================
           HEADER
        ========================================================== */

        .analytics-header {
            background: linear-gradient(135deg,
                    #111827,
                    #1f2937);
            border-radius: 22px;
            padding: 30px;
            color: white;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12);
        }

        .analytics-header h2 {
            font-weight: 700;
            margin-bottom: 7px;
        }

        .analytics-header p {
            color: rgba(255, 255, 255, 0.65);
            margin-bottom: 0;
        }

        .back-btn {
            border-radius: 10px;
            padding: 9px 16px;
            font-weight: 600;
        }


        /* =========================================================
           STAT CARDS
        ========================================================== */

        .stat-card {
            border: 0;
            border-radius: 18px;
            background: white;
            box-shadow: 0 7px 22px rgba(15, 23, 42, 0.06);
            transition: all 0.25s ease;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.10);
        }

        .stat-card-body {
            padding: 22px;
        }

        .stat-label {
            color: #6b7280;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .stat-number {
            font-size: 30px;
            font-weight: 750;
            line-height: 1;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .icon-blue {
            background: #e8f1ff;
        }

        .icon-green {
            background: #e8f8ef;
        }

        .icon-purple {
            background: #f1eaff;
        }

        .icon-cyan {
            background: #e8faff;
        }


        /* =========================================================
           PERIOD CARDS
        ========================================================== */

        .period-card {
            border: 0;
            border-radius: 18px;
            background: white;
            box-shadow: 0 7px 22px rgba(15, 23, 42, 0.06);
        }

        .period-card .card-body {
            padding: 25px;
        }

        .period-title {
            color: #6b7280;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .period-number {
            font-size: 36px;
            font-weight: 750;
            margin: 8px 0 2px;
        }

        .period-subtitle {
            color: #9ca3af;
            font-size: 13px;
        }


        /* =========================================================
           MAIN CARDS
        ========================================================== */

        .analytics-card {
            border: 0;
            border-radius: 18px;
            background: white;
            box-shadow: 0 7px 22px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .analytics-card-header {
            padding: 20px 22px;
            border-bottom: 1px solid #eef0f3;
            background: white;
        }

        .analytics-card-header h5 {
            font-size: 17px;
            font-weight: 700;
            margin: 0;
        }

        .analytics-card-body {
            padding: 22px;
        }


        /* =========================================================
           TABLE
        ========================================================== */

        .analytics-table {
            margin-bottom: 0;
        }

        .analytics-table thead th {
            background: #f8fafc;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            font-weight: 700;
            padding: 14px 18px;
            border-bottom: 1px solid #eef0f3;
        }

        .analytics-table tbody td {
            padding: 16px 18px;
            vertical-align: middle;
            border-color: #f0f2f5;
        }

        .analytics-table tbody tr:hover {
            background: #fafcff;
        }

        .rank {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #eef4ff;
            color: #0d6efd;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
        }

        .product-link {
            color: #1f2937;
            font-weight: 650;
            text-decoration: none;
        }

        .product-link:hover {
            color: #0d6efd;
        }

        .scan-count {
            font-size: 15px;
            font-weight: 700;
        }


        /* =========================================================
           STATUS
        ========================================================== */

        .status-badge {
            padding: 6px 11px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }


        /* =========================================================
           DEVICE / BROWSER / OS
        ========================================================== */

        .stats-list {
            display: flex;
            flex-direction: column;
        }

        .stats-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 13px 0;
            border-bottom: 1px solid #eef0f3;
        }

        .stats-row:last-child {
            border-bottom: 0;
        }

        .stats-name {
            color: #4b5563;
            font-size: 14px;
        }

        .stats-total {
            min-width: 36px;
            text-align: center;
            padding: 5px 9px;
            background: #f1f5f9;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
        }

        .empty-data {
            text-align: center;
            padding: 25px 10px;
            color: #9ca3af;
            font-size: 14px;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================== */

        @media (max-width: 767px) {

            .analytics-header {
                padding: 22px;
            }

            .header-button {
                margin-top: 18px;
            }

            .stat-number {
                font-size: 25px;
            }

            .period-number {
                font-size: 30px;
            }

        }
    </style>

</head>


<body>


    <div class="container py-4 py-md-5">


        {{-- =========================================================
         HEADER
    ========================================================== --}}

        <div class="analytics-header mb-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">

                <div>

                    <h2>
                        📊 QR Analytics
                    </h2>

                    <p>
                        Monitor your QR code performance and scan activity
                    </p>

                </div>

                <div class="header-button">

                    <a
                        href="{{ route('products.index') }}"
                        class="btn btn-light back-btn">

                        ← Products

                    </a>

                </div>

            </div>

        </div>


        {{-- =========================================================
         MAIN STATISTICS
    ========================================================== --}}

        <div class="row g-3 mb-4">


            {{-- TOTAL PRODUCTS --}}

            <div class="col-6 col-lg-3">

                <div class="card stat-card h-100">

                    <div class="stat-card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="stat-label">
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


            {{-- ACTIVE PRODUCTS --}}

            <div class="col-6 col-lg-3">

                <div class="card stat-card h-100">

                    <div class="stat-card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="stat-label">
                                    Active Products
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


            {{-- TOTAL SCANS --}}

            <div class="col-6 col-lg-3">

                <div class="card stat-card h-100">

                    <div class="stat-card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="stat-label">
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


            {{-- TODAY --}}

            <div class="col-6 col-lg-3">

                <div class="card stat-card h-100">

                    <div class="stat-card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="stat-label">
                                    Today's Scans
                                </div>

                                <div class="stat-number text-info">
                                    {{ $todayScans }}
                                </div>

                            </div>

                            <div class="stat-icon icon-cyan">
                                ⚡
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
         WEEK / MONTH
    ========================================================== --}}

        <div class="row g-3 mb-4">


            {{-- THIS WEEK --}}

            <div class="col-md-6">

                <div class="card period-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="period-title">
                                    This Week
                                </div>

                                <div class="period-number">
                                    {{ $weekScans }}
                                </div>

                                <div class="period-subtitle">
                                    QR scans during the last 7 days
                                </div>

                            </div>

                            <div class="fs-1">
                                📅
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- THIS MONTH --}}

            <div class="col-md-6">

                <div class="card period-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="period-title">
                                    This Month
                                </div>

                                <div class="period-number">
                                    {{ $monthScans }}
                                </div>

                                <div class="period-subtitle">
                                    QR scans during this month
                                </div>

                            </div>

                            <div class="fs-1">
                                📈
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
         TOP PRODUCTS
    ========================================================== --}}

        <div class="card analytics-card mb-4">

            <div class="analytics-card-header">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5>
                            🏆 Most Scanned Products
                        </h5>

                        <small class="text-muted">
                            Products receiving the highest number of QR scans
                        </small>

                    </div>

                </div>

            </div>


            <div class="table-responsive">

                <table class="table analytics-table">

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Product
                            </th>

                            <th>
                                Price
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end">
                                Total Scans
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($topProducts as $index => $product)

                        <tr>

                            <td>

                                <span class="rank">

                                    {{ $index + 1 }}

                                </span>

                            </td>


                            <td>

                                <a
                                    href="{{ route(
                                        'products.show',
                                        $product->id
                                    ) }}"
                                    class="product-link">

                                    {{ $product->name }}

                                </a>

                            </td>


                            <td>

                                <span class="fw-semibold">

                                    ₹{{ number_format(
                                        $product->price,
                                        2
                                    ) }}

                                </span>

                            </td>


                            <td>

                                @if($product->status === 'active')

                                <span class="badge bg-success status-badge">

                                    Active

                                </span>

                                @else

                                <span class="badge bg-danger status-badge">

                                    Inactive

                                </span>

                                @endif

                            </td>


                            <td class="text-end">

                                <span class="scan-count">

                                    {{ $product->qr_scans_count }}

                                </span>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="5"
                                class="empty-data">

                                📊 No scan data available yet.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =========================================================
         DEVICE / BROWSER / OS
    ========================================================== --}}

        <div class="row g-4">


            {{-- DEVICES --}}

            <div class="col-lg-4">

                <div class="card analytics-card h-100">

                    <div class="analytics-card-header">

                        <h5>
                            📱 Devices
                        </h5>

                        <small class="text-muted">
                            Scans by device type
                        </small>

                    </div>


                    <div class="analytics-card-body">

                        <div class="stats-list">

                            @forelse($deviceStats as $item)

                            <div class="stats-row">

                                <span class="stats-name">

                                    {{ $item->device }}

                                </span>

                                <span class="stats-total">

                                    {{ $item->total }}

                                </span>

                            </div>

                            @empty

                            <div class="empty-data">

                                No device data available.

                            </div>

                            @endforelse

                        </div>

                    </div>

                </div>

            </div>


            {{-- BROWSERS --}}

            <div class="col-lg-4">

                <div class="card analytics-card h-100">

                    <div class="analytics-card-header">

                        <h5>
                            🌐 Browsers
                        </h5>

                        <small class="text-muted">
                            Scans by browser
                        </small>

                    </div>


                    <div class="analytics-card-body">

                        <div class="stats-list">

                            @forelse($browserStats as $item)

                            <div class="stats-row">

                                <span class="stats-name">

                                    {{ $item->browser }}

                                </span>

                                <span class="stats-total">

                                    {{ $item->total }}

                                </span>

                            </div>

                            @empty

                            <div class="empty-data">

                                No browser data available.

                            </div>

                            @endforelse

                        </div>

                    </div>

                </div>

            </div>


            {{-- OPERATING SYSTEMS --}}

            <div class="col-lg-4">

                <div class="card analytics-card h-100">

                    <div class="analytics-card-header">

                        <h5>
                            💻 Operating Systems
                        </h5>

                        <small class="text-muted">
                            Scans by operating system
                        </small>

                    </div>


                    <div class="analytics-card-body">

                        <div class="stats-list">

                            @forelse($osStats as $item)

                            <div class="stats-row">

                                <span class="stats-name">

                                    {{ $item->operating_system }}

                                </span>

                                <span class="stats-total">

                                    {{ $item->total }}

                                </span>

                            </div>

                            @empty

                            <div class="empty-data">

                                No operating system data available.

                            </div>

                            @endforelse

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
         FOOTER
    ========================================================== --}}

        <div class="text-center mt-5">

            <small class="text-muted">

                QR Analytics Dashboard

            </small>

        </div>


    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>


</body>

</html>
