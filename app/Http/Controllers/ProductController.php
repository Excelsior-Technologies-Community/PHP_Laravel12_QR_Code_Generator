<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::create($request->only('name', 'description', 'price'));

        // Generate QR code pointing to product detail page
        $qrFileName = 'product_' . $product->id . '.svg';
        $qrPath = public_path('qrcode/' . $qrFileName);
        $productUrl = route('products.show', $product->id);

        QrCode::size(300)->generate($productUrl, $qrPath);

        $product->update(['qr_code' => $qrFileName]);

        return redirect()->route('products.show', $product->id)->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        if ($product->qr_code && file_exists(public_path('qrcode/' . $product->qr_code))) {
            unlink(public_path('qrcode/' . $product->qr_code));
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted!');
    }
}
