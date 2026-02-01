@extends('layouts.user')

@section('title', 'Yêu cầu hỗ trợ của tôi')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0" style="color: #000; letter-spacing: 0.05em;">Yêu cầu hỗ trợ của tôi</h3>
                <a href="{{ route('support.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tạo yêu cầu mới
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($tickets->isEmpty())
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                        <p class="text-muted mb-3">Bạn chưa có yêu cầu hỗ trợ nào</p>
                        <a href="{{ route('support.create') }}" class="btn btn-primary">Tạo yêu cầu hỗ trợ đầu tiên</a>
                    </div>
                </div>
            @else
                <div class="row g-3">
                    @foreach($tickets as $ticket)
                        @php
                            $statusColors = [
                                'open' => 'primary',
                                'in_progress' => 'warning',
                                'resolved' => 'success',
                                'closed' => 'secondary'
                            ];
                            $statusLabels = [
                                'open' => 'Mở',
                                'in_progress' => 'Đang xử lý',
                                'resolved' => 'Đã giải quyết',
                                'closed' => 'Đã đóng'
                            ];
                            $priorityColors = [
                                'low' => 'secondary',
                                'medium' => 'warning',
                                'high' => 'danger',
                                'urgent' => 'dark'
                            ];
                            $priorityLabels = [
                                'low' => 'Thấp',
                                'medium' => 'Trung bình',
                                'high' => 'Cao',
                                'urgent' => 'Khẩn cấp'
                            ];
                        @endphp
                        <div class="col-md-6 col-lg-6">
                            <div class="card h-100 shadow-sm border-0 hover-shadow" style="cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
                                        <h5 class="card-title mb-0" style="word-break: break-word !important; word-wrap: break-word !important; overflow-wrap: break-word !important; white-space: normal !important; hyphens: auto; flex: 1; max-width: calc(100% - 60px); display: block; line-height: 1.4; color: #000; letter-spacing: 0.05em;">
                                            {{ $ticket->subject }}
                                        </h5>
                                        <small class="text-muted text-nowrap flex-shrink-0" style="color: #000; letter-spacing: 0.05em;">#{{ $ticket->id }}</small>
                                    </div>

                                    <p class="card-text text-muted small mb-3" style="word-break: break-word; white-space: normal;">
                                        {{ Str::limit($ticket->description, 80, '...') }}
                                    </p>

                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="badge bg-{{ $statusColors[$ticket->status] ?? 'secondary' }}">
                                            {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                                        </span>
                                        <span class="badge bg-{{ $priorityColors[$ticket->priority] ?? 'secondary' }}">
                                            {{ $priorityLabels[$ticket->priority] ?? $ticket->priority }}
                                        </span>
                                        @if($ticket->category)
                                            <span class="badge bg-info">{{ $ticket->category }}</span>
                                        @endif
                                    </div>

                                    <div class="border-top pt-2 mb-3 small text-muted">
                                        <div class="d-flex justify-content-between">
                                            <span><i class="fas fa-clock"></i> {{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                                            <span><i class="fas fa-comments"></i> {{ count($ticket->responses) }} phản hồi</span>
                                        </div>
                                    </div>

                                    <a href="{{ route('support.show', $ticket) }}" class="btn btn-sm btn-outline-primary w-100">
                                        <i class="fas fa-eye"></i> Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endsection