@extends('layouts.user')

@section('title', 'Tạo yêu cầu hỗ trợ')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-bottom">
                    <h4 class="mb-0" style="color: #000; letter-spacing: 0.05em;">
                        <i class="fas fa-edit"></i> Tạo yêu cầu hỗ trợ mới
                    </h4>
                </div>

                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Lỗi!</strong> Vui lòng kiểm tra lại các trường dưới đây.
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('support.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Danh mục -->
                        <div class="mb-4">
                            <label for="category" class="form-label">
                                <i class="fas fa-list"></i> Danh mục
                            </label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category">
                                <option value="">-- Chọn danh mục --</option>
                                <option value="Sản phẩm" {{ old('category') === 'Sản phẩm' ? 'selected' : '' }}>Sản phẩm</option>
                                <option value="Đơn hàng" {{ old('category') === 'Đơn hàng' ? 'selected' : '' }}>Đơn hàng</option>
                                <option value="Thanh toán" {{ old('category') === 'Thanh toán' ? 'selected' : '' }}>Thanh toán</option>
                                <option value="Vận chuyển" {{ old('category') === 'Vận chuyển' ? 'selected' : '' }}>Vận chuyển</option>
                                <option value="Tài khoản" {{ old('category') === 'Tài khoản' ? 'selected' : '' }}>Tài khoản</option>
                                <option value="Khác" {{ old('category') === 'Khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tiêu đề -->
                        <div class="mb-4">
                            <label for="subject" class="form-label">
                                <i class="fas fa-heading"></i> Tiêu đề <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" name="subject" placeholder="Nhập tiêu đề yêu cầu..."
                                   value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Tiêu đề giúp chúng tôi hiểu vấn đề của bạn một cách nhanh chóng</small>
                        </div>

                        <!-- Mô tả -->
                        <div class="mb-4">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left"></i> Mô tả chi tiết <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="6" 
                                      placeholder="Mô tả chi tiết vấn đề của bạn. Càng chi tiết càng tốt..."
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Tối thiểu 10 ký tự</small>
                        </div>

                        <!-- Độ ưu tiên -->
                        <div class="mb-4">
                            <label for="priority" class="form-label">
                                <i class="fas fa-exclamation-triangle"></i> Độ ưu tiên
                            </label>
                            <select class="form-select @error('priority') is-invalid @enderror" 
                                    id="priority" name="priority">
                                <option value="low" {{ old('priority', 'medium') === 'low' ? 'selected' : '' }}>
                                    <i class="fas fa-arrow-down"></i> Thấp - Không gấp gáp
                                </option>
                                <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>
                                    <i class="fas fa-minus"></i> Trung bình - Bình thường
                                </option>
                                <option value="high" {{ old('priority', 'medium') === 'high' ? 'selected' : '' }}>
                                    <i class="fas fa-arrow-up"></i> Cao - Cần xử lý sớm
                                </option>
                                <option value="urgent" {{ old('priority', 'medium') === 'urgent' ? 'selected' : '' }}>
                                    <i class="fas fa-fire"></i> Khẩn cấp - Rất cần xử lý
                                </option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('support.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-redo"></i> Đặt lại
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Gửi yêu cầu
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Gợi ý -->
            <div class="card mt-4 bg-light border-0">
                <div class="card-body">
                    <h6 class="card-title" style="color: #000; letter-spacing: 0.05em;">
                        <i class="fas fa-lightbulb text-warning"></i> Mẹo tạo yêu cầu hiệu quả
                    </h6>
                    <ul class="small mb-0">
                        <li>Chọn danh mục phù hợp để được xử lý nhanh hơn</li>
                        <li>Cung cấp tiêu đề ngắn gọn, rõ ràng về vấn đề</li>
                        <li>Mô tả chi tiết các bước bạn đã thực hiện</li>
                        <li>Nếu liên quan đến đơn hàng, hãy ghi mã đơn hàng</li>
                        <li>Chọn độ ưu tiên hợp lý để được hỗ trợ đúng lúc</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
