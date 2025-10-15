<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class AdminPageController extends Controller
{
    public function show($page = 'index')
    {
        $page = trim($page, '/');
        $viewName = 'admin.pages.' . str_replace('/', '.', $page);

        if (View::exists($viewName)) return view($viewName);
        if (View::exists($viewName . '.index')) return view($viewName . '.index');

        abort(404);
    }
}
