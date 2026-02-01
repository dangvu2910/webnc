<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
    // API endpoint for autocomplete suggestions
    public function autocomplete(Request $request)
    {
        $q = trim($request->get('q', ''));
        
        if (strlen($q) < 1) {
            return response()->json([]);
        }

        $products = Product::where('is_active', true)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%')
                      ->orWhere('sku', 'like', '%' . $q . '%')
                      ->orWhere('brand', 'like', '%' . $q . '%');
            })
            ->select('id', 'name', 'sku', 'price', 'sale_price', 'image')
            ->limit(8)
            ->get();

        return response()->json($products);
    }

    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $categoryId = $request->get('category_id', null);
        $results = [];
        $categories = Category::all();

        if ($q !== '') {
            // Search products by name, description, SKU, brand, material
            $query = Product::query()
                ->where('is_active', true);

            // Filter by category if selected
            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }

            $results = $query->where(function ($subQuery) use ($q) {
                    $subQuery->where('name', 'like', '%' . $q . '%')
                              ->orWhere('description', 'like', '%' . $q . '%')
                              ->orWhere('sku', 'like', '%' . $q . '%')
                              ->orWhere('brand', 'like', '%' . $q . '%')
                              ->orWhere('material', 'like', '%' . $q . '%');
                })
                ->orderByDesc('is_featured')
                ->orderByDesc('sales_count')
                ->orderByDesc('rating')
                ->orderBy('name')
                ->paginate(12);
        }

        return view('user.search_results', [
            'q' => $q, 
            'results' => $results,
            'categories' => $categories,
            'selectedCategory' => $categoryId
        ]);
    }
}
