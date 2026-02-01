<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    // List products (DB-driven)
    public function index()
    {
        // show only active products if the column exists, else fallback to all
        $query = Product::query();
        try {
            if (Schema::hasColumn('products', 'is_active')) {
                $query->where('is_active', 1);
            }
        } catch (\Throwable $e) {
            // ignore schema check errors on some environments
        }

        $products = $query->orderBy('created_at', 'desc')->get();
        return view('user.index', compact('products'));
    }

    // Show single product
    public function show(Request $request, $id)
    {
        $product = null;

        // Try finding by SKU first (most common)
        $product = Product::where('sku', $id)->first();

        // Try finding by slug
        if (!$product) {
            $product = Product::where('slug', $id)->first();
        }

        // Try finding by numeric ID
        if (!$product && is_numeric($id)) {
            $product = Product::find($id);
        }

        // Handle demo pages for men-X and women-X format
        if (!$product && preg_match('/^(men|women)-(\d+)$/', $id, $matches)) {
            $gender = $matches[1];
            $num = (int) $matches[2];
            
            // Define product names and prices (same as in men/women views)
            $names = ['Nike Dunk Low Blue', 'Nike Air Force 1', 'Nike Free RN', 'Nike Revolution', 'Nike Court Borough', 'Adidas Stan Smith', 'Adidas NMD R1', 'New Balance 990', 'Puma RS-X'];
            $prices = [499000, 599000, 699000, 799000, 899000];
            $stocks = [5, 10, 8, 3, 15, 12, 7, 6, 4]; // Stock for each product
            $salePrices = [399000, 499000, 599000, 699000, 799000]; // Sale prices (some products have discounts)
            
            $name = $names[$num - 1] ?? "Sản phẩm $gender $num";
            $price = $prices[($num - 1) % 5];
            $stock = $stocks[$num - 1] ?? 10;
            $salePrice = $salePrices[($num - 1) % 5] < $price ? $salePrices[($num - 1) % 5] : null; // Only show sale price if it's lower
            $imageIndex = ($num % 10) + 1;
            if ($imageIndex == 0) $imageIndex = 10;

            $demo = [
                'id' => $id,
                'sku' => $id,
                'name' => $name,
                'price' => $price,
                'sale_price' => $salePrice,
                'stock' => $stock,
                'image' => "user/images/card-item{$imageIndex}.jpg",
                'description' => "Mô tả demo cho {$name}",
            ];

            return view('user.product', ['product' => $demo]);
        }

        if (!$product) {
            abort(404);
        }

        return view('user.product', ['product' => $product->toArray()]);
    }
}
