@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng - Nhân viên')

@section('content')
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Quản lý đơn hàng
    </h2>

    <!-- Filters -->
    <div class="mb-6 p-4 bg-white rounded-lg shadow dark:bg-gray-800">
        <form method="GET" class="flex gap-4 flex-wrap">
            <input type="text" name="search" placeholder="Tìm kiếm..." value="{{ request('search') }}" 
                class="px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600">
            <select name="status" class="px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600">
                <option value="">Tất cả trạng thái</option>
                <option value="pending" @selected(request('status') === 'pending')>Chờ xử lý</option>
                <option value="processing" @selected(request('status') === 'processing')>Đang xử lý</option>
                <option value="shipped" @selected(request('status') === 'shipped')>Đã gửi</option>
                <option value="delivered" @selected(request('status') === 'delivered')>Đã giao</option>
                <option value="cancelled" @selected(request('status') === 'cancelled')>Bị hủy</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Tìm kiếm
            </button>
        </form>
    </div>

    <!-- Orders Table -->
    @if ($orders->count() > 0)
        <div class="overflow-x-auto bg-white rounded-lg shadow dark:bg-gray-800">
            <table class="w-full">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Mã đơn</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Khách hàng</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Tổng giá</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Trạng thái</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Ngày tạo</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700 dark:text-gray-200">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border-t dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300">#{{ $order->id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $order->user->name ?? 'Guest' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ number_format($order->total, 0, ',', '.') }} ₫</td>
                            <td class="px-4 py-2 text-sm">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ \App\Helpers\OrderHelper::getStatusBadgeTailwind($order->status) }}">
                                    {{ \App\Helpers\OrderHelper::getStatusLabel($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2 text-center text-sm">
                                <a href="{{ route('staff.orders.show', $order) }}" class="text-blue-500 hover:text-blue-700 font-semibold">
                                    Xem
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
            <p class="text-gray-600 dark:text-gray-400">Không tìm thấy đơn hàng nào.</p>
        </div>
    @endif
@endsection
