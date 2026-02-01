<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\SupportTicket;

class DashboardController extends Controller
{
    public function index()
    {
        // Total customers
        $totalCustomers = User::where('is_admin', 0)->count();

        // Total revenue (from all paid orders)
        $totalRevenue = Order::whereIn('status', ['completed', 'paid', 'delivered'])
            ->sum('total');

        // New orders (pending or processing)
        $newOrders = Order::whereIn('status', ['pending', 'processing'])->count();

        // Pending support tickets
        $pendingSupport = SupportTicket::where('status', 'open')->count();

        return view('admin.index', [
            'totalCustomers' => $totalCustomers,
            'totalRevenue' => $totalRevenue,
            'newOrders' => $newOrders,
            'pendingSupport' => $pendingSupport,
        ]);
    }
}
