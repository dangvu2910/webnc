@extends('layouts.admin')

@section('title', 'Chi tiết yêu cầu hỗ trợ - #' . $ticket->id)

@section('content')
    <div class="container px-6 mx-auto grid">
        <div class="my-6">
            <a href="{{ route('admin.support.index') }}" class="text-blue-600 hover:underline">&larr; Quay lại</a>
        </div>

        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded bg-green-100 border border-green-400 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Ticket Info -->
                <div class="bg-white rounded-lg shadow-md p-6 dark:bg-gray-800 mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">{{ $ticket->subject }}</h2>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">#{{ $ticket->id }}</p>
                        </div>
                        @php
                            $statusLabels = [
                                'open' => 'Mở',
                                'in_progress' => 'Đang xử lý',
                                'resolved' => 'Đã giải quyết',
                                'closed' => 'Đã đóng'
                            ];
                        @endphp
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 uppercase">Khách hàng</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $ticket->user->name }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->user->email }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 uppercase">Danh mục</p>
                            <p class="font-semibold text-gray-900 dark:text-white">
                                @if($ticket->category)
                                    {{ $ticket->category }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 uppercase">Ngày tạo</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 uppercase">Số phản hồi</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ count($responses) }}</p>
                        </div>
                    </div>

                    <hr class="my-4 dark:border-gray-700">

                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Nội dung yêu cầu:</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded" style="white-space: pre-wrap;">
                        {{ $ticket->description }}
                    </div>
                </div>

                <!-- Responses -->
                <div class="bg-white rounded-lg shadow-md p-6 dark:bg-gray-800 mb-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Cuộc trò chuyện</h3>

                    <div class="space-y-4 mb-6" style="max-height: 500px; overflow-y: auto;">
                        @if($responses->isEmpty())
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">Chưa có phản hồi nào.</p>
                        @else
                            @foreach($responses as $response)
                                <div class="border border-gray-200 dark:border-gray-700 rounded p-4 {{ $response->is_admin_response ? 'bg-blue-50 dark:bg-blue-900' : '' }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">
                                                {{ $response->user->name }}
                                                @if($response->is_admin_response)
                                                    <span class="inline-block ml-2 px-2 py-1 text-xs bg-green-100 text-green-900 dark:bg-green-600 dark:text-white rounded">Admin</span>
                                                @else
                                                    <span class="inline-block ml-2 px-2 py-1 text-xs bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white rounded">Khách hàng</span>
                                                @endif
                                            </p>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $response->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300" style="white-space: pre-wrap;">{{ $response->response_text }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Add Response Form -->
                    <hr class="my-4 dark:border-gray-700">

                    <form method="POST" action="{{ route('support.addResponse', $ticket) }}" class="bg-gray-50 dark:bg-gray-700 p-4 rounded">
                        @csrf

                        <div class="mb-3">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Phản hồi từ Admin</label>
                            <textarea name="response_text" rows="4" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-600 dark:text-white focus:ring focus:ring-blue-300" placeholder="Nhập phản hồi của bạn..."></textarea>
                        </div>

                        <button type="submit" class="w-full px-8 py-3 text-base font-semibold bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            <svg class="inline-block w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Gửi phản hồi
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar - Status & Actions -->
            <div class="lg:col-span-1">
                <!-- Status Update -->
                <div class="bg-white rounded-lg shadow-md p-6 dark:bg-gray-800 mb-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Cập nhật trạng thái</h3>

                    <form method="POST" action="{{ route('admin.support.updateStatus', $ticket) }}" class="space-y-3">
                        @csrf

                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 uppercase mb-2">Trạng thái hiện tại</label>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white mb-3">
                                @php
                                    $statusLabels = [
                                        'open' => 'Mở',
                                        'in_progress' => 'Đang xử lý',
                                        'resolved' => 'Đã giải quyết',
                                        'closed' => 'Đã đóng'
                                    ];
                                @endphp
                                {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                            </p>

                            <select name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white">
                                <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Mở</option>
                                <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Đã giải quyết</option>
                                <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Đã đóng</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Cập nhật</button>
                    </form>
                </div>

                <!-- Priority Update -->
                <div class="bg-white rounded-lg shadow-md p-6 dark:bg-gray-800 mb-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Cập nhật độ ưu tiên</h3>

                    <form method="POST" action="{{ route('admin.support.updatePriority', $ticket) }}" class="space-y-3">
                        @csrf

                        <div>
                            @php
                                $priorityLabels = [
                                    'low' => 'Thấp',
                                    'medium' => 'Trung bình',
                                    'high' => 'Cao',
                                    'urgent' => 'Khẩn cấp'
                                ];
                            @endphp
                            <label class="block text-xs text-gray-600 dark:text-gray-400 uppercase mb-2">Độ ưu tiên hiện tại</label>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white mb-3">
                                {{ $priorityLabels[$ticket->priority] ?? $ticket->priority }}
                            </p>

                            <select name="priority" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white">
                                <option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>Thấp</option>
                                <option value="medium" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>Trung bình</option>
                                <option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>Cao</option>
                                <option value="urgent" {{ $ticket->priority === 'urgent' ? 'selected' : '' }}>Khẩn cấp</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Cập nhật</button>
                    </form>
                </div>

                <!-- Delete -->
                <div class="bg-white rounded-lg shadow-md p-6 dark:bg-gray-800">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Hành động khác</h3>

                    <form method="POST" action="{{ route('admin.support.destroy', $ticket) }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa yêu cầu này?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Xóa yêu cầu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
