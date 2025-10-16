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
        // support lookup by numeric id, slug, or sku (legacy p1..p10)
        $product = null;

        // look by id if numeric
        if (is_numeric($id)) {
            $product = Product::find($id);
        }

        // fallback to slug or sku
        if (! $product) {
            $product = Product::where('slug', $id)->orWhere('sku', $id)->first();
        }

        if (! $product) {
            abort(404);
        }

        return view('user.product', ['product' => $product->toArray()]);
    }
}
