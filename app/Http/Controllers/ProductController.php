<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\QrScan;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    /**
     * Display all products.
     */
    public function index()
    {
        $products = Product::latest()->get();

        return view('products.index', compact('products'));
    }

    /**
     * Show create product form.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a new product and generate QR code.
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
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'qr_foreground_color' => $validated['qr_foreground_color'],
            'qr_background_color' => $validated['qr_background_color'],
            'qr_size' => $validated['qr_size'],
        ]);

        $this->generateProductQr($product);

        return redirect()
            ->route('products.show', $product->id)
            ->with('success', 'Product created and QR code generated successfully!');
    }

    /**
     * Display product details.
     *
     * Every visit to this page is considered a QR scan.
     */
    public function show(Request $request, Product $product)
    {
        $this->recordQrScan($request, $product);

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

        $lastScan = $product->qrScans()
            ->latest('scanned_at')
            ->first();

        $recentScans = $product->qrScans()
            ->latest('scanned_at')
            ->take(10)
            ->get();

        return view('products.show', compact(
            'product',
            'totalScans',
            'todayScans',
            'weekScans',
            'lastScan',
            'recentScans'
        ));
    }

    /**
     * Show QR customization page.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update product information and QR customization.
     */
    public function update(Request $request, Product $product)
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
        ]);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'qr_foreground_color' => $validated['qr_foreground_color'],
            'qr_background_color' => $validated['qr_background_color'],
            'qr_size' => $validated['qr_size'],
        ]);

        $this->generateProductQr($product);

        return redirect()
            ->route('products.show', $product->id)
            ->with('success', 'Product and QR code updated successfully!');
    }

    /**
     * Regenerate only the QR code.
     */
    public function regenerateQr(Product $product)
    {
        $this->generateProductQr($product);

        return redirect()
            ->route('products.show', $product->id)
            ->with('success', 'QR code regenerated successfully!');
    }

    /**
     * Delete product and QR code.
     */
    public function destroy(Product $product)
    {
        if (
            $product->qr_code &&
            file_exists(public_path('qrcode/' . $product->qr_code))
        ) {
            unlink(public_path('qrcode/' . $product->qr_code));
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Generate QR code for a product.
     */
    private function generateProductQr(Product $product): void
    {
        $directory = public_path('qrcode');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (
            $product->qr_code &&
            file_exists($directory . '/' . $product->qr_code)
        ) {
            unlink($directory . '/' . $product->qr_code);
        }

        $qrFileName = 'product_' . $product->id . '.svg';

        $qrPath = $directory . '/' . $qrFileName;

        /*
     * QR points to dedicated tracking URL.
     */
        $productUrl = route('products.qr.redirect', $product->id);

        $foreground = $this->hexToRgb(
            $product->qr_foreground_color ?: '#000000'
        );

        $background = $this->hexToRgb(
            $product->qr_background_color ?: '#ffffff'
        );

        QrCode::size($product->qr_size ?: 300)
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
            ->generate($productUrl, $qrPath);

        $product->update([
            'qr_code' => $qrFileName,
        ]);
    }

    /**
     * Convert HEX color to RGB.
     */
    private function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2)),
        ];
    }

    /**
     * Record QR scan information.
     */
    private function recordQrScan(
        Request $request,
        Product $product
    ): void {
        $userAgent = $request->userAgent();

        QrScan::create([
            'product_id' => $product->id,
            'ip_address' => $request->ip(),
            'user_agent' => $userAgent,
            'device' => $this->detectDevice($userAgent),
            'browser' => $this->detectBrowser($userAgent),
            'operating_system' => $this->detectOperatingSystem($userAgent),
            'scanned_at' => now(),
        ]);
    }

    /**
     * Detect device.
     */
    private function detectDevice(?string $userAgent): string
    {
        if (!$userAgent) {
            return 'Unknown';
        }

        if (preg_match('/tablet|ipad/i', $userAgent)) {
            return 'Tablet';
        }

        if (preg_match('/mobile|iphone|android/i', $userAgent)) {
            return 'Mobile';
        }

        return 'Desktop';
    }

    /**
     * Detect browser.
     */
    private function detectBrowser(?string $userAgent): string
    {
        if (!$userAgent) {
            return 'Unknown';
        }

        if (preg_match('/edg/i', $userAgent)) {
            return 'Microsoft Edge';
        }

        if (preg_match('/opr|opera/i', $userAgent)) {
            return 'Opera';
        }

        if (preg_match('/chrome/i', $userAgent)) {
            return 'Google Chrome';
        }

        if (preg_match('/firefox/i', $userAgent)) {
            return 'Mozilla Firefox';
        }

        if (preg_match('/safari/i', $userAgent)) {
            return 'Safari';
        }

        return 'Unknown';
    }

    /**
     * Detect operating system.
     */
    private function detectOperatingSystem(?string $userAgent): string
    {
        if (!$userAgent) {
            return 'Unknown';
        }

        if (preg_match('/windows nt 10/i', $userAgent)) {
            return 'Windows';
        }

        if (preg_match('/windows/i', $userAgent)) {
            return 'Windows';
        }

        if (preg_match('/iphone|ipad|ios/i', $userAgent)) {
            return 'iOS';
        }

        if (preg_match('/android/i', $userAgent)) {
            return 'Android';
        }

        if (preg_match('/macintosh|mac os x/i', $userAgent)) {
            return 'macOS';
        }

        if (preg_match('/linux/i', $userAgent)) {
            return 'Linux';
        }

        return 'Unknown';
    }

    public function qrRedirect(Request $request, Product $product)
    {
        $this->recordQrScan($request, $product);

        return redirect()->route('products.show', $product->id);
    }
}
