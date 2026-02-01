@extends('layouts.admin')

@section('title', 'Chi tiết yêu cầu hỗ trợ #' . $ticket->id)

@section('content')
    <div class="mb-6 flex gap-4">
        <a href="{{ route('staff.support.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            ← Quay lại
        </a>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Ticket Header -->
    <div class="mb-6 p-6 bg-white rounded-lg shadow dark:bg-gray-800">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-4">
                    {{ $ticket->subject }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mb-2">
                    <strong>ID:</strong> #{{ $ticket->id }}
                </p>
                <p class="text-gray-600 dark:text-gray-400 mb-2">
                    <strong>Khách hàng:</strong> {{ $ticket->user->name }} ({{ $ticket->user->email }})
                </p>
                <p class="text-gray-600 dark:text-gray-400 mb-2">
                    <strong>Danh mục:</strong> {{ $ticket->category ?? 'N/A' }}
                </p>
                <p class="text-gray-600 dark:text-gray-400">
                    <strong>Ngày tạo:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
            <div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Độ ưu tiên
                    </label>
                    <span class="px-4 py-2 text-sm font-semibold rounded-full
                        @if ($ticket->priority === 'urgent') bg-red-100 text-red-800
                        @elseif ($ticket->priority === 'high') bg-orange-100 text-orange-800
                        @elseif ($ticket->priority === 'medium') bg-yellow-100 text-yellow-800
                        @else bg-green-100 text-green-800 @endif">
                        {{ ucfirst($ticket->priority) }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Trạng thái
                    </label>
                    <span class="px-4 py-2 text-sm font-semibold rounded-full
                        @if ($ticket->status === 'open') bg-red-100 text-red-800
                        @elseif ($ticket->status === 'in_progress') bg-blue-100 text-blue-800
                        @elseif ($ticket->status === 'resolved') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-3">
                Mô tả yêu cầu
            </h3>
            <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">
                {{ $ticket->description }}
            </p>
        </div>
    </div>

    <!-- Responses Section -->
    <div class="mb-6 p-6 bg-white rounded-lg shadow dark:bg-gray-800">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-6">
            Phản hồi ({{ $ticket->responses->count() }})
        </h3>

        <div class="space-y-4 mb-6">
            @forelse ($ticket->responses as $response)
                <div class="p-4 border rounded
                    @if ($response->is_admin_response) bg-blue-50 dark:bg-blue-900 border-blue-200 dark:border-blue-700
                    @else bg-gray-50 dark:bg-gray-700 border-gray-200 dark:border-gray-600 @endif">
                    <div class="flex items-center gap-2 mb-2">
                        <strong class="text-gray-700 dark:text-gray-300">{{ $response->user->name }}</strong>
                        @if ($response->is_admin_response)
                            <span class="px-2 py-1 text-xs font-semibold bg-blue-200 text-blue-800 rounded">
                                Nhân viên
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold bg-gray-200 text-gray-800 rounded">
                                Khách hàng
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                        {{ $response->created_at->format('d/m/Y H:i') }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                        {{ $response->response_text }}
                    </p>
                </div>
            @empty
                <p class="text-gray-600 dark:text-gray-400">Chưa có phản hồi nào.</p>
            @endforelse
        </div>

        <!-- Add Response Form -->
        @if ($ticket->status !== 'closed')
            <form method="POST" action="{{ route('staff.support.addResponse', $ticket) }}" class="border-t pt-6">
                @csrf
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Thêm phản hồi
                </label>
                <textarea name="response_text" rows="4" 
                    class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                    placeholder="Nhập phản hồi của bạn..." required></textarea>
                @error('response_text')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <button type="submit" class="mt-4 w-full sm:w-auto px-8 py-3 text-base font-semibold bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <svg class="inline-block w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Gửi phản hồi
                </button>
            </form>
        @endif
    </div>

    <!-- Update Status and Priority -->
    @if ($ticket->status !== 'closed')
        <div class="mb-6 p-6 bg-white rounded-lg shadow dark:bg-gray-800">
            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-4">
                Cập nhật
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <form method="POST" action="{{ route('staff.support.updateStatus', $ticket) }}">
                    @csrf
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Trạng thái
                    </label>
                    <div class="flex gap-2">
                        <select name="status" class="flex-1 px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                            <option value="open" @selected($ticket->status === 'open')>Mở</option>
                            <option value="in_progress" @selected($ticket->status === 'in_progress')>Đang xử lý</option>
                            <option value="resolved" @selected($ticket->status === 'resolved')>Đã giải quyết</option>
                            <option value="closed" @selected($ticket->status === 'closed')>Đã đóng</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Cập nhật
                        </button>
                    </div>
                </form>

                <form method="POST" action="{{ route('staff.support.updatePriority', $ticket) }}">
                    @csrf
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Độ ưu tiên
                    </label>
                    <div class="flex gap-2">
                        <select name="priority" class="flex-1 px-4 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                            <option value="low" @selected($ticket->priority === 'low')>Thấp</option>
                            <option value="medium" @selected($ticket->priority === 'medium')>Trung bình</option>
                            <option value="high" @selected($ticket->priority === 'high')>Cao</option>
                            <option value="urgent" @selected($ticket->priority === 'urgent')>Khẩn cấp</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
