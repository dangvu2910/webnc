@extends('layouts.admin')

@section('title', 'Trang chủ - Dashboard Nhân viên')

@section('content')
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Dashboard - Nhân viên
    </h2>

    <!-- Cards -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Total Orders Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Tổng đơn hàng
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $totalOrders }}
                </p>
            </div>
        </div>

        <!-- Today Orders Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h12a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Đơn hàng hôm nay
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $todayOrders }}
                </p>
            </div>
        </div>

        <!-- Total Support Tickets Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Tổng yêu cầu hỗ trợ
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $totalTickets }}
                </p>
            </div>
        </div>

        <!-- Today Support Tickets Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Yêu cầu hôm nay
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $todayTickets }}
                </p>
            </div>
        </div>
    </div>

    <!-- Pending Orders Section -->
    <div class="mb-8 p-6 bg-white rounded-lg shadow">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">
            Đơn hàng chờ xử lý
        </h3>

        @if ($pendingOrders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Mã đơn</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Khách hàng</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Trạng thái</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Ngày tạo</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700 dark:text-gray-200">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingOrders as $order)
                            <tr class="border-t dark:border-gray-600">
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">#{{ $order->id }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $order->user->name ?? 'Guest' }}</td>
                                <td class="px-4 py-2 text-sm">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ \App\Helpers\OrderHelper::getStatusBadgeTailwind($order->status) }}">
                                        {{ \App\Helpers\OrderHelper::getStatusLabel($order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2 text-center text-sm">
                                    <a href="{{ route('staff.orders.show', $order) }}" class="text-blue-500 hover:text-blue-700">Xem chi tiết</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <a href="{{ route('staff.orders.index') }}" class="text-blue-500 hover:text-blue-700 text-sm font-semibold">
                    Xem tất cả đơn hàng →
                </a>
            </div>
        @else
            <p class="text-gray-600 dark:text-gray-400">Không có đơn hàng chờ xử lý.</p>
        @endif
    </div>

    <!-- Pending Support Tickets Section -->
    <div class="mb-8 p-6 bg-white rounded-lg shadow">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">
            Yêu cầu hỗ trợ chờ xử lý
        </h3>

        @if ($pendingTickets->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">ID</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Tiêu đề</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Khách hàng</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Độ ưu tiên</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Trạng thái</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700 dark:text-gray-200">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingTickets as $ticket)
                            <tr class="border-t dark:border-gray-600">
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">#{{ $ticket->id }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ Str::limit($ticket->subject, 30) }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $ticket->user->name ?? 'Unknown' }}</td>
                                <td class="px-4 py-2 text-sm">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if ($ticket->priority === 'urgent') bg-red-100 text-red-800
                                        @elseif ($ticket->priority === 'high') bg-orange-100 text-orange-800
                                        @elseif ($ticket->priority === 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if ($ticket->status === 'open') bg-red-100 text-red-800
                                        @elseif ($ticket->status === 'in_progress') bg-blue-100 text-blue-800
                                        @elseif ($ticket->status === 'resolved') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center text-sm">
                                    <a href="{{ route('staff.support.show', $ticket) }}" class="text-blue-500 hover:text-blue-700">Xem chi tiết</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <a href="{{ route('staff.support.index') }}" class="text-blue-500 hover:text-blue-700 text-sm font-semibold">
                    Xem tất cả yêu cầu →
                </a>
            </div>
        @else
            <p class="text-gray-600 dark:text-gray-400">Không có yêu cầu hỗ trợ chờ xử lý.</p>
        @endif
    </div>
@endsection
