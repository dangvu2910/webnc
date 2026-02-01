@extends('layouts.user')

@section('title', 'Chi tiết yêu cầu hỗ trợ - #' . $ticket->id)

@section('content')
<div class="container-fluid py-3" style="background-color: #f5f5f5; height: 100vh; display: flex; flex-direction: column;">
    <div class="row h-100 g-0">
        <!-- Chat Sidebar -->
        <div class="col-lg-3 d-none d-lg-block border-end" style="background-color: white; overflow-y: auto;">
            <div class="p-3 border-bottom sticky-top bg-white">
                <a href="{{ route('support.index') }}" class="btn btn-sm btn-outline-secondary w-100">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                </a>
            </div>

            <div class="p-3">
                <h6 class="mb-3" style="color: #000; font-weight: normal;">CHI TIẾT YÊU CẦU</h6>
                
                @php
                    $statusLabels = [
                        'open' => 'Mở',
                        'in_progress' => 'Đang xử lý',
                        'resolved' => 'Đã giải quyết',
                        'closed' => 'Đã đóng'
                    ];
                    $statusColors = [
                        'open' => 'primary',
                        'in_progress' => 'warning',
                        'resolved' => 'success',
                        'closed' => 'secondary'
                    ];
                    $priorityLabels = [
                        'low' => 'Thấp',
                        'medium' => 'Trung bình',
                        'high' => 'Cao',
                        'urgent' => 'Khẩn cấp'
                    ];
                    $priorityColors = [
                        'low' => 'secondary',
                        'medium' => 'warning',
                        'high' => 'danger',
                        'urgent' => 'dark'
                    ];
                @endphp

                <div class="mb-3">
                    <small style="color: #000; font-weight: normal; display: block;">Trạng thái</small>
                    <div><span class="badge bg-{{ $statusColors[$ticket->status] }} w-100" style="padding: 0.5rem;">
                        {{ $statusLabels[$ticket->status] }}
                    </span></div>
                </div>

                <div class="mb-3">
                    <small style="color: #000; font-weight: normal; display: block;">Độ ưu tiên</small>
                    <div><span class="badge bg-{{ $priorityColors[$ticket->priority] }} w-100" style="padding: 0.5rem;">
                        {{ $priorityLabels[$ticket->priority] }}
                    </span></div>
                </div>

                @if($ticket->category)
                    <div class="mb-3">
                        <small style="color: #000; font-weight: normal; display: block;">Danh mục</small>
                        <div class="mt-1">{{ $ticket->category }}</div>
                    </div>
                @endif

                <div class="mb-3">
                    <small style="color: #000; font-weight: normal; display: block;">Ngày tạo</small>
                    <div class="mt-1" style="font-size: 0.9rem;">{{ $ticket->created_at->format('d/m/Y H:i') }}</div>
                </div>

                <div class="mb-3">
                    <small style="color: #000; font-weight: normal; display: block;">Cập nhật lần cuối</small>
                    <div class="mt-1" style="font-size: 0.9rem;">{{ $ticket->updated_at->format('d/m/Y H:i') }}</div>
                </div>

                <hr>

                <div>
                    <small style="color: #000; font-weight: normal; display: block;">Số phản hồi</small>
                    <div class="mt-1"><strong>{{ count($responses) }}</strong></div>
                </div>
            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="col-lg-9 d-flex flex-column">
            <!-- Header -->
            <div class="bg-white border-bottom p-3 sticky-top" style="box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0" style="color: #000; letter-spacing: 0.05em; font-weight: 600;">{{ $ticket->subject }}</h5>
                        <small style="color: #000; font-weight: normal;">#{{ $ticket->id }}</small>
                    </div>
                    <div class="d-lg-none">
                        <a href="{{ route('support.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert" style="margin-top: 1rem !important;">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Messages Area -->
            <div class="flex-grow-1 overflow-auto p-3" id="messagesContainer" style="background-color: #f5f5f5;">
                <!-- Initial Ticket Message -->
                <div class="mb-3">
                    <div class="d-flex gap-2">
                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 40px; height: 40px; flex-shrink: 0;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex gap-2 align-items-baseline mb-1">
                                <strong style="color: #000; letter-spacing: 0.05em;">{{ auth()->user()->name }}</strong>
                                <small class="text-muted">{{ $ticket->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="bg-white p-3 rounded" style="border-radius: 12px; word-wrap: break-word;">
                                <strong class="d-block mb-2 text-primary">Yêu cầu ban đầu:</strong>
                                <div style="white-space: pre-wrap;">{{ $ticket->description }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responses -->
                @if($responses->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-comment-slash" style="font-size: 2rem; opacity: 0.3;"></i>
                        <p class="mt-2">Chưa có phản hồi nào. Admin sẽ trả lời sớm nhất có thể.</p>
                    </div>
                @else
                    @foreach($responses as $response)
                        <div class="mb-3 {{ $response->is_admin_response ? 'ms-3' : 'me-3' }}">
                            <div class="d-flex gap-2 {{ $response->is_admin_response ? 'flex-row-reverse' : '' }}">
                                <div class="avatar rounded-circle d-flex align-items-center justify-content-center text-white" 
                                     style="width: 40px; height: 40px; flex-shrink: 0; background-color: {{ $response->is_admin_response ? '#28a745' : '#6c757d' }};">
                                    {{ strtoupper(substr($response->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex gap-2 align-items-baseline mb-1 {{ $response->is_admin_response ? 'flex-row-reverse' : '' }}">
                                        <strong style="color: #000; letter-spacing: 0.05em;">{{ $response->user->name }}</strong>
                                        @if($response->is_admin_response)
                                            <span class="badge bg-success">Admin</span>
                                        @endif
                                        <small class="text-muted">{{ $response->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <div class="p-3 rounded" 
                                         style="background-color: {{ $response->is_admin_response ? '#e8f5e9' : '#ffffff' }}; 
                                                 border-radius: 12px; 
                                                 border-left: 3px solid {{ $response->is_admin_response ? '#28a745' : '#ddd' }};
                                                 word-wrap: break-word;">
                                        <div style="white-space: pre-wrap;">{{ $response->response_text }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Input Area -->
            @if($ticket->status !== 'closed')
                <div class="bg-white border-top p-3">
                    <form method="POST" action="{{ route('support.addResponse', $ticket) }}" class="d-flex gap-2">
                        @csrf
                        <textarea name="response_text" class="form-control @error('response_text') is-invalid @enderror" 
                                  placeholder="Nhập phản hồi của bạn..." rows="3" required 
                                  style="resize: vertical; min-height: 50px;"></textarea>
                        <button type="submit" class="btn btn-primary btn-lg px-5 py-2" style="align-self: flex-end; font-size: 1rem; font-weight: 600;">
                            <i class="fas fa-paper-plane me-2"></i> Gửi
                        </button>
                    </form>
                    @error('response_text')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>
            @else
                <div class="bg-light border-top p-3 text-center text-muted">
                    <i class="fas fa-lock"></i> Yêu cầu này đã đóng. Bạn không thể thêm phản hồi mới.
                </div>
            @endif
        </div>
    </div>
</div>

@if($ticket->status !== 'closed')
    <div class="position-fixed bottom-0 start-0 p-3" style="z-index: 100;">
        <form method="POST" action="{{ route('support.close', $ticket) }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger" 
                    onclick="return confirm('Bạn có chắc chắn muốn đóng yêu cầu này không?')">
                <i class="fas fa-times"></i> Đóng yêu cầu
            </button>
        </form>
    </div>
@endif

<script>
    // Auto scroll to bottom
    const messagesContainer = document.getElementById('messagesContainer');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Auto-refresh messages every 5 seconds
    setInterval(function() {
        fetch(window.location.href, { 
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(html, 'text/html');
            const newMessages = newDoc.getElementById('messagesContainer');
            if (newMessages && newMessages.innerHTML !== messagesContainer.innerHTML) {
                messagesContainer.innerHTML = newMessages.innerHTML;
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });
    }, 5000);
</script>

<style>
    .avatar {
        font-weight: 700;
        font-size: 0.9rem;
    }
</style>
@endsection
