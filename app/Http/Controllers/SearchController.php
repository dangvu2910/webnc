<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        // Very small, local search over sample product names / categories
        $results = [];

        if ($q !== '') {
            $qLower = mb_strtolower($q);

            // sample items (in a real app you'd query the DB)
            $items = [
                ['title' => 'Giày chạy bộ nam', 'url' => url('/men')],
                ['title' => 'Giày chạy bộ nữ', 'url' => url('/women')],
                ['title' => 'Sneaker nam', 'url' => url('/men')],
                ['title' => 'Sneaker nữ', 'url' => url('/women')],
                ['title' => 'Giày thời trang', 'url' => url('/')],
            ];

            foreach ($items as $item) {
                if (mb_strpos(mb_strtolower($item['title']), $qLower) !== false) {
                    $results[] = $item;
                }
            }
        }

        return view('user.search_results', ['q' => $q, 'results' => $results]);
    }
}
