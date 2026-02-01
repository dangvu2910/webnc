<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Show list of orders
     */
    public function index()
    {
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('staff.orders.index', compact('orders'));
    }

    /**
     * Show order detail
     */
    public function show(Order $order)
    {
        $order->load('user', 'orderItems.product');
        return view('staff.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Order $order)
    {
        $status = request('status');
        
        if (!in_array($status, ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])) {
            return back()->withErrors('Invalid status');
        }

        $order->update(['status' => $status]);

        return back()->with('success', 'Trạng thái đơn hàng đã được cập nhật!');
    }

    /**
     * Approve order (confirm payment)
     */
    public function approve(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->withErrors('Chỉ có thể phê duyệt đơn hàng đang chờ xử lý!');
        }

        $order->update(['status' => 'processing']);

        return back()->with('success', 'Đơn hàng đã được phê duyệt và chuyển sang trạng thái đang xử lý!');
    }

    /**
     * Reject order
     */
    public function reject(Order $order)
    {
        if (!in_array($order->status, ['pending', 'processing'])) {
            return back()->withErrors('Không thể từ chối đơn hàng đã gửi hoặc đã giao!');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Đơn hàng đã bị từ chối!');
    }
}
