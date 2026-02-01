@extends('layouts.admin')

@section('title', 'Quản lý hỗ trợ khách hàng - Nhân viên')

@section('content')
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Quản lý yêu cầu hỗ trợ
    </h2>

    <!-- Filters -->
    <div class="mb-6 p-4 bg-white rounded-lg shadow dark:bg-gray-800">
        <form method="GET" class="flex gap-4 flex-wrap">
            <select name="status" class="px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 text-gray-700 dark:text-gray-300">
                <option value="">Tất cả trạng thái</option>
                <option value="open" @selected(request('status') === 'open')>Mở</option>
                <option value="in_progress" @selected(request('status') === 'in_progress')>Đang xử lý</option>
                <option value="resolved" @selected(request('status') === 'resolved')>Đã giải quyết</option>
                <option value="closed" @selected(request('status') === 'closed')>Đã đóng</option>
            </select>
            <select name="priority" class="px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 text-gray-700 dark:text-gray-300">
                <option value="">Tất cả độ ưu tiên</option>
                <option value="low" @selected(request('priority') === 'low')>Thấp</option>
                <option value="medium" @selected(request('priority') === 'medium')>Trung bình</option>
                <option value="high" @selected(request('priority') === 'high')>Cao</option>
                <option value="urgent" @selected(request('priority') === 'urgent')>Khẩn cấp</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Lọc
            </button>
        </form>
    </div>

    <!-- Tickets Table -->
    @if ($tickets->count() > 0)
        <div class="overflow-x-auto bg-white rounded-lg shadow dark:bg-gray-800">
            <table class="w-full">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Tiêu đề</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Khách hàng</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Độ ưu tiên</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Trạng thái</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Ngày tạo</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700 dark:text-gray-200">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr class="border-t dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300">#{{ $ticket->id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ Str::limit($ticket->subject, 40) }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $ticket->user->name }}</td>
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
                            <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2 text-center text-sm">
                                <a href="{{ route('staff.support.show', $ticket) }}" class="text-blue-500 hover:text-blue-700 font-semibold">
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
            {{ $tickets->links() }}
        </div>
    @else
        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
            <p class="text-gray-600 dark:text-gray-400">Không tìm thấy yêu cầu hỗ trợ nào.</p>
        </div>
    @endif
@endsection
