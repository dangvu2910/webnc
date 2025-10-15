<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'fullname' => ['required','string','max:255'],
            'email' => ['required','email','max:255'],
            'address' => ['required','string'],
            'payment_method' => ['nullable','string'],
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->withErrors(['cart' => 'Giỏ hàng trống']);
        }

        $subtotal = 0;
        foreach ($cart as $c) { $subtotal += $c['price'] * $c['qty']; }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'fullname' => $data['fullname'],
                'email' => $data['email'],
                'address' => $data['address'],
                'payment_method' => $data['payment_method'] ?? null,
                'subtotal' => $subtotal,
                'shipping' => 0,
                'total' => $subtotal,
                'status' => 'processing',
            ]);

            foreach ($cart as $c) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $c['id'] ?? null,
                    'name' => $c['name'],
                    'price' => $c['price'],
                    'qty' => $c['qty'],
                    'total' => $c['price'] * $c['qty'],
                ]);
            }

            DB::commit();
            // clear cart
            $request->session()->forget('cart');
            return redirect('/index')->with('status','Đặt hàng thành công! Mã đơn: '.$order->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['order' => 'Không thể tạo đơn hàng: '.$e->getMessage()]);
        }
    }
}
