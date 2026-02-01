@extends('layouts.admin')

@section('title', 'Quản lý Yêu cầu hỗ trợ')

@section('content')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200" style="color: #000; letter-spacing: 0.05em;">
            Quản lý Yêu cầu hỗ trợ
        </h2>

        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded bg-green-100 border border-green-400 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Mã yêu cầu</th>
                            <th class="px-4 py-3">Khách hàng</th>
                            <th class="px-4 py-3">Tiêu đề</th>
                            <th class="px-4 py-3">Danh mục</th>
                            <th class="px-4 py-3">Độ ưu tiên</th>
                            <th class="px-4 py-3">Trạng thái</th>
                            <th class="px-4 py-3">Ngày tạo</th>
                            <th class="px-4 py-3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @forelse($tickets as $ticket)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 text-sm font-semibold">
                                    #{{ $ticket->id }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div>
                                        <p class="font-semibold" style="color: #000; letter-spacing: 0.05em;">{{ $ticket->user->name }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $ticket->user->email }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ Str::limit($ticket->subject, 30) }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($ticket->category)
                                        <span class="inline-block px-2 py-1 text-xs rounded bg-blue-100 text-blue-900 dark:bg-blue-600 dark:text-white">
                                            {{ $ticket->category }}
                                        </span>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    @php
                                        $priorityColors = [
                                            'low' => 'bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white',
                                            'medium' => 'bg-yellow-100 text-yellow-900 dark:bg-yellow-600 dark:text-white',
                                            'high' => 'bg-red-100 text-red-900 dark:bg-red-600 dark:text-white',
                                            'urgent' => 'bg-red-200 text-red-900 dark:bg-red-700 dark:text-white'
                                        ];
                                        $priorityLabels = [
                                            'low' => 'Thấp',
                                            'medium' => 'Trung bình',
                                            'high' => 'Cao',
                                            'urgent' => 'Khẩn cấp'
                                        ];
                                    @endphp
                                    <span class="inline-block px-2 py-1 rounded font-semibold {{ $priorityColors[$ticket->priority] ?? 'bg-gray-100' }}">
                                        {{ $priorityLabels[$ticket->priority] ?? $ticket->priority }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    @php
                                        $statusColors = [
                                            'open' => 'bg-blue-100 text-blue-900 dark:bg-blue-600 dark:text-white',
                                            'in_progress' => 'bg-yellow-100 text-yellow-900 dark:bg-yellow-600 dark:text-white',
                                            'resolved' => 'bg-green-100 text-green-900 dark:bg-green-600 dark:text-white',
                                            'closed' => 'bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white'
                                        ];
                                        $statusLabels = [
                                            'open' => 'Mở',
                                            'in_progress' => 'Đang xử lý',
                                            'resolved' => 'Đã giải quyết',
                                            'closed' => 'Đã đóng'
                                        ];
                                    @endphp
                                    <span class="inline-block px-2 py-1 rounded font-semibold {{ $statusColors[$ticket->status] ?? 'bg-gray-100' }}">
                                        {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $ticket->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <a href="{{ route('admin.support.show', $ticket) }}" class="text-blue-600 hover:underline">
                                        Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-3 text-center text-gray-500">
                                    Không có yêu cầu hỗ trợ nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($tickets->total() > 0)
            <div class="my-6 flex justify-center">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>
@endsection
