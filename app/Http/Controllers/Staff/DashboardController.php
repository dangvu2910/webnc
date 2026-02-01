<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SupportTicket;

class DashboardController extends Controller
{
    /**
     * Show the staff dashboard
     */
    public function index()
    {
        // Get orders that need attention
        $pendingOrders = Order::with('user')
            ->whereIn('status', ['pending', 'processing', 'shipped'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get support tickets that need attention
        $pendingTickets = SupportTicket::with('user')
            ->whereIn('status', ['open', 'in_progress'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get stats (matching admin dashboard logic)
        $totalOrders = Order::whereIn('status', ['pending', 'processing', 'shipped'])->count();
        $totalTickets = SupportTicket::whereIn('status', ['open', 'in_progress'])->count();
        $todayOrders = Order::whereIn('status', ['pending', 'processing', 'shipped'])
            ->whereDate('created_at', today())->count();
        $todayTickets = SupportTicket::whereIn('status', ['open', 'in_progress'])
            ->whereDate('created_at', today())->count();

        return view('staff.dashboard', compact(
            'pendingOrders',
            'pendingTickets',
            'totalOrders',
            'totalTickets',
            'todayOrders',
            'todayTickets'
        ));
    }
}
