<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\QrScan;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    /**
     * ============================================================
     * 1. PRODUCT SEARCH + PAGINATION + STATUS FILTER
     * ============================================================
     */
    public function index(Request $request)
    {
        $query = Product::query();

        /*
         * Search by product name or description.
         */
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        /*
         * Filter by status.
         */
        if (
            $request->filled('status') &&
            in_array($request->status, ['active', 'inactive'])
        ) {
            $query->where('status', $request->status);
        }

        /*
         * Pagination.
         */
        $products = $query
            ->latest()
            ->paginate(6)
            ->withQueryString();

        /*
         * Statistics.
         */
        $totalProducts = Product::count();

        $activeProducts = Product::where('status', 'active')->count();

        $inactiveProducts = Product::where('status', 'inactive')->count();

        $totalScans = QrScan::count();

        return view('products.index', compact(
            'products',
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'totalScans'
        ));
    }


    /**
     * ============================================================
     * CREATE PRODUCT
     * ============================================================
     */
    public function create()
    {
        return view('products.create');
    }


    /**
     * ============================================================
     * STORE PRODUCT + GENERATE QR
     * ============================================================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'description' => 'nullable|string',

            'price' => 'required|numeric|min:0',

            'qr_foreground_color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'qr_background_color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'qr_size' => 'required|integer|min:200|max:1000',

            'status' => 'required|in:active,inactive',
        ]);

        $product = Product::create([
            'name' => $validated['name'],

            'description' => $validated['description'] ?? null,

            'price' => $validated['price'],

            'qr_foreground_color' =>
            $validated['qr_foreground_color'],

            'qr_background_color' =>
            $validated['qr_background_color'],

            'qr_size' => $validated['qr_size'],

            'status' => $validated['status'],
        ]);

        $this->generateProductQr($product);

        return redirect()
            ->route('products.show', $product->id)
            ->with(
                'success',
                'Product created and QR code generated successfully!'
            );
    }


    /**
     * ============================================================
     * SHOW PRODUCT + QR ANALYTICS
     * ============================================================
     */
    public function show(Request $request, Product $product)
    {
        /*
         * Do NOT count normal product-page visits as scans anymore.
         *
         * Only the dedicated QR redirect records a scan.
         */

        $totalScans = $product->qrScans()->count();

        $todayScans = $product->qrScans()
            ->whereDate('scanned_at', today())
            ->count();

        $weekScans = $product->qrScans()
            ->whereBetween('scanned_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])
            ->count();

        $monthScans = $product->qrScans()
            ->whereMonth('scanned_at', now()->month)
            ->whereYear('scanned_at', now()->year)
            ->count();

        $lastScan = $product->qrScans()
            ->latest('scanned_at')
            ->first();

        /*
         * Scan history pagination.
         */
        $recentScans = $product->qrScans()
            ->latest('scanned_at')
            ->paginate(10)
            ->withQueryString();

        return view('products.show', compact(
            'product',
            'totalScans',
            'todayScans',
            'weekScans',
            'monthScans',
            'lastScan',
            'recentScans'
        ));
    }


    /**
     * ============================================================
     * EDIT PRODUCT
     * ============================================================
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }


    /**
     * ============================================================
     * UPDATE PRODUCT + REGENERATE QR
     * ============================================================
     */
    public function update(
        Request $request,
        Product $product
    ) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'description' => 'nullable|string',

            'price' => 'required|numeric|min:0',

            'qr_foreground_color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'qr_background_color' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],

            'qr_size' => 'required|integer|min:200|max:1000',

            'status' => 'required|in:active,inactive',
        ]);

        $product->update([
            'name' => $validated['name'],

            'description' => $validated['description'] ?? null,

            'price' => $validated['price'],

            'qr_foreground_color' =>
            $validated['qr_foreground_color'],

            'qr_background_color' =>
            $validated['qr_background_color'],

            'qr_size' => $validated['qr_size'],

            'status' => $validated['status'],
        ]);

        $this->generateProductQr($product);

        return redirect()
            ->route('products.show', $product->id)
            ->with(
                'success',
                'Product and QR code updated successfully!'
            );
    }


    /**
     * ============================================================
     * REGENERATE QR
     * ============================================================
     */
    public function regenerateQr(Product $product)
    {
        $this->generateProductQr($product);

        return redirect()
            ->route('products.show', $product->id)
            ->with(
                'success',
                'QR code regenerated successfully!'
            );
    }


    /**
     * ============================================================
     * 2. DOWNLOAD QR AS PNG
     * ============================================================
     */
    public function downloadQr(Product $product)
    {
        $productUrl = route(
            'products.qr.redirect',
            $product->id
        );

        $foreground = $this->hexToRgb(
            $product->qr_foreground_color ?: '#000000'
        );

        $background = $this->hexToRgb(
            $product->qr_background_color ?: '#ffffff'
        );

        $qrCode = QrCode::format('png')
            ->size($product->qr_size ?: 300)
            ->color(
                $foreground['r'],
                $foreground['g'],
                $foreground['b']
            )
            ->backgroundColor(
                $background['r'],
                $background['g'],
                $background['b']
            )
            ->generate($productUrl);

        return response($qrCode)
            ->header('Content-Type', 'image/png')
            ->header(
                'Content-Disposition',
                'attachment; filename="qr-' .
                    $product->id .
                    '.png"'
            );
    }


    /**
     * ============================================================
     * 3. OVERALL QR ANALYTICS DASHBOARD
     * ============================================================
     */
    public function analytics()
    {
        $totalProducts = Product::count();

        $activeProducts = Product::where(
            'status',
            'active'
        )->count();

        $inactiveProducts = Product::where(
            'status',
            'inactive'
        )->count();

        $totalScans = QrScan::count();

        $todayScans = QrScan::whereDate(
            'scanned_at',
            today()
        )->count();

        $weekScans = QrScan::whereBetween(
            'scanned_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]
        )->count();

        $monthScans = QrScan::whereMonth(
            'scanned_at',
            now()->month
        )
            ->whereYear(
                'scanned_at',
                now()->year
            )
            ->count();

        /*
         * Most scanned products.
         */
        $topProducts = Product::withCount('qrScans')
            ->orderByDesc('qr_scans_count')
            ->take(10)
            ->get();

        /*
         * Device statistics.
         */
        $deviceStats = QrScan::selectRaw(
            'device, COUNT(*) as total'
        )
            ->groupBy('device')
            ->orderByDesc('total')
            ->get();

        /*
         * Browser statistics.
         */
        $browserStats = QrScan::selectRaw(
            'browser, COUNT(*) as total'
        )
            ->groupBy('browser')
            ->orderByDesc('total')
            ->get();

        /*
         * Operating system statistics.
         */
        $osStats = QrScan::selectRaw(
            'operating_system, COUNT(*) as total'
        )
            ->groupBy('operating_system')
            ->orderByDesc('total')
            ->get();

        return view('products.analytics', compact(
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'totalScans',
            'todayScans',
            'weekScans',
            'monthScans',
            'topProducts',
            'deviceStats',
            'browserStats',
            'osStats'
        ));
    }


    /**
     * ============================================================
     * 4. TOGGLE PRODUCT STATUS
     * ============================================================
     */
    public function toggleStatus(Product $product)
    {
        $product->status =
            $product->status === 'active'
            ? 'inactive'
            : 'active';

        $product->save();

        return redirect()
            ->back()
            ->with(
                'success',
                'Product status changed to ' .
                    ucfirst($product->status) .
                    ' successfully!'
            );
    }


    /**
     * ============================================================
     * 5. EXPORT QR SCANS TO CSV
     * ============================================================
     */
    public function exportScans(Product $product)
    {
        $fileName =
            'product-' .
            $product->id .
            '-qr-scans-' .
            now()->format('Y-m-d-H-i-s') .
            '.csv';

        $scans = $product->qrScans()
            ->latest('scanned_at')
            ->get();

        $headers = [
            'Content-Type' =>
            'text/csv; charset=UTF-8',

            'Content-Disposition' =>
            'attachment; filename="' .
                $fileName .
                '"',
        ];

        $callback = function () use ($scans) {

            $file = fopen('php://output', 'w');

            /*
             * CSV header.
             */
            fputcsv($file, [
                'ID',
                'Product',
                'IP Address',
                'Device',
                'Browser',
                'Operating System',
                'User Agent',
                'Scanned At',
            ]);

            foreach ($scans as $scan) {

                fputcsv($file, [
                    $scan->id,

                    $scan->product->name,

                    $scan->ip_address,

                    $scan->device,

                    $scan->browser,

                    $scan->operating_system,

                    $scan->user_agent,

                    $scan->scanned_at
                        ? $scan->scanned_at
                        ->format('Y-m-d H:i:s')
                        : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream(
            $callback,
            200,
            $headers
        );
    }


    /**
     * ============================================================
     * DELETE PRODUCT
     * ============================================================
     */
    public function destroy(Product $product)
    {
        if (
            $product->qr_code &&
            file_exists(
                public_path(
                    'qrcode/' .
                        $product->qr_code
                )
            )
        ) {
            unlink(
                public_path(
                    'qrcode/' .
                        $product->qr_code
                )
            );
        }

        /*
         * Delete scan records.
         */
        $product->qrScans()->delete();

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product deleted successfully!'
            );
    }


    /**
     * ============================================================
     * GENERATE PRODUCT QR
     * ============================================================
     */
    private function generateProductQr(
        Product $product
    ): void {
        $directory = public_path('qrcode');

        if (!is_dir($directory)) {
            mkdir(
                $directory,
                0755,
                true
            );
        }

        /*
         * Remove old QR.
         */
        if (
            $product->qr_code &&
            file_exists(
                $directory .
                    '/' .
                    $product->qr_code
            )
        ) {
            unlink(
                $directory .
                    '/' .
                    $product->qr_code
            );
        }

        $qrFileName =
            'product_' .
            $product->id .
            '.svg';

        $qrPath =
            $directory .
            '/' .
            $qrFileName;

        /*
         * QR → tracking URL.
         */
        $productUrl = route(
            'products.qr.redirect',
            $product->id
        );

        $foreground = $this->hexToRgb(
            $product->qr_foreground_color
                ?: '#000000'
        );

        $background = $this->hexToRgb(
            $product->qr_background_color
                ?: '#ffffff'
        );

        QrCode::size(
            $product->qr_size ?: 300
        )
            ->color(
                $foreground['r'],
                $foreground['g'],
                $foreground['b']
            )
            ->backgroundColor(
                $background['r'],
                $background['g'],
                $background['b']
            )
            ->generate(
                $productUrl,
                $qrPath
            );

        $product->update([
            'qr_code' => $qrFileName,
        ]);
    }


    /**
     * ============================================================
     * HEX → RGB
     * ============================================================
     */
    private function hexToRgb(
        string $hex
    ): array {
        $hex = ltrim($hex, '#');

        return [
            'r' => hexdec(
                substr($hex, 0, 2)
            ),

            'g' => hexdec(
                substr($hex, 2, 2)
            ),

            'b' => hexdec(
                substr($hex, 4, 2)
            ),
        ];
    }


    /**
     * ============================================================
     * RECORD QR SCAN
     * ============================================================
     *
     * 6. Duplicate scan prevention:
     * Same product + same IP within 30 seconds
     * will not create another scan.
     */
    private function recordQrScan(
        Request $request,
        Product $product
    ): void {
        /*
         * Inactive products don't record scans.
         */
        if ($product->status !== 'active') {
            return;
        }

        $ipAddress = $request->ip();

        /*
         * Check recent scan.
         */
        $recentScan = $product->qrScans()
            ->where('ip_address', $ipAddress)
            ->where(
                'scanned_at',
                '>=',
                now()->subSeconds(30)
            )
            ->exists();

        if ($recentScan) {
            return;
        }

        $userAgent = $request->userAgent();

        QrScan::create([
            'product_id' =>
            $product->id,

            'ip_address' =>
            $ipAddress,

            'user_agent' =>
            $userAgent,

            'device' =>
            $this->detectDevice(
                $userAgent
            ),

            'browser' =>
            $this->detectBrowser(
                $userAgent
            ),

            'operating_system' =>
            $this->detectOperatingSystem(
                $userAgent
            ),

            'scanned_at' =>
            now(),
        ]);
    }


    /**
     * ============================================================
     * DEVICE DETECTION
     * ============================================================
     */
    private function detectDevice(
        ?string $userAgent
    ): string {
        if (!$userAgent) {
            return 'Unknown';
        }

        if (
            preg_match(
                '/tablet|ipad/i',
                $userAgent
            )
        ) {
            return 'Tablet';
        }

        if (
            preg_match(
                '/mobile|iphone|android/i',
                $userAgent
            )
        ) {
            return 'Mobile';
        }

        return 'Desktop';
    }


    /**
     * ============================================================
     * BROWSER DETECTION
     * ============================================================
     */
    private function detectBrowser(
        ?string $userAgent
    ): string {
        if (!$userAgent) {
            return 'Unknown';
        }

        if (
            preg_match(
                '/edg/i',
                $userAgent
            )
        ) {
            return 'Microsoft Edge';
        }

        if (
            preg_match(
                '/opr|opera/i',
                $userAgent
            )
        ) {
            return 'Opera';
        }

        if (
            preg_match(
                '/chrome/i',
                $userAgent
            )
        ) {
            return 'Google Chrome';
        }

        if (
            preg_match(
                '/firefox/i',
                $userAgent
            )
        ) {
            return 'Mozilla Firefox';
        }

        if (
            preg_match(
                '/safari/i',
                $userAgent
            )
        ) {
            return 'Safari';
        }

        return 'Unknown';
    }


    /**
     * ============================================================
     * OS DETECTION
     * ============================================================
     */
    private function detectOperatingSystem(
        ?string $userAgent
    ): string {
        if (!$userAgent) {
            return 'Unknown';
        }

        if (
            preg_match(
                '/windows nt 10/i',
                $userAgent
            )
        ) {
            return 'Windows';
        }

        if (
            preg_match(
                '/windows/i',
                $userAgent
            )
        ) {
            return 'Windows';
        }

        if (
            preg_match(
                '/iphone|ipad|ios/i',
                $userAgent
            )
        ) {
            return 'iOS';
        }

        if (
            preg_match(
                '/android/i',
                $userAgent
            )
        ) {
            return 'Android';
        }

        if (
            preg_match(
                '/macintosh|mac os x/i',
                $userAgent
            )
        ) {
            return 'macOS';
        }

        if (
            preg_match(
                '/linux/i',
                $userAgent
            )
        ) {
            return 'Linux';
        }

        return 'Unknown';
    }


    /**
     * ============================================================
     * QR REDIRECT
     * ============================================================
     */
    public function qrRedirect(
        Request $request,
        Product $product
    ) {
        /*
         * If product inactive, don't allow normal QR access.
         */
        if ($product->status !== 'active') {
            return redirect()
                ->route(
                    'products.show',
                    $product->id
                )
                ->with(
                    'error',
                    'This product is currently inactive.'
                );
        }

        /*
         * Record actual QR scan.
         */
        $this->recordQrScan(
            $request,
            $product
        );

        return redirect()->route(
            'products.show',
            $product->id
        );
    }
}
