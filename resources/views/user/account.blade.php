@extends('layouts.user')

@section('title', 'Tài khoản của tôi')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-12 col-md-4">
            <div class="card p-4 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="avatar bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width:76px;height:76px;font-size:28px;font-weight:700;color:#333;">
                        {{ strtoupper(substr(auth()->user()->name ?? (auth()->user()->email ?? 'U'),0,1)) }}
                    </div>
                    <div>
                        <h4 class="mb-0">{{ auth()->user()->name }}</h4>
                        <small class="text-muted d-block">{{ auth()->user()->email }}</small>
                    </div>
                </div>

                <hr>
                <ul class="list-unstyled small mb-3">
                    <li><strong>ID:</strong> {{ auth()->user()->id }}</li>
                    <li><strong>Username:</strong> {{ auth()->user()->username ?? '-' }}</li>
                    <li><strong>Admin:</strong> {{ auth()->user()->is_admin ? 'Có' : 'Không' }}</li>
                </ul>

                <div class="d-grid gap-2">
                    <a href="{{ url('/account/edit') }}" class="btn btn-outline-secondary">Chỉnh sửa thông tin</a>
                    <a href="{{ url('/account/password') }}" class="btn btn-outline-primary">Đổi mật khẩu</a>
                    <a href="{{ route('support.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-headset"></i> Hỗ trợ khách hàng
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Đăng xuất</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-8">
            <div class="card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Đơn hàng gần đây</h5>
                @if(isset($orders) && count($orders))
                    <ul class="list-group">
                        @foreach($orders as $order)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">Đơn hàng #{{ $order->id }}</div>
                                    <small class="text-muted">Ngày đặt: {{ $order->created_at->format('d/m/Y') }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold">{{ number_format($order->total, 0, ',', '.') }} ₫</div>
                                    <span class="badge bg-{{ \App\Helpers\OrderHelper::getStatusBadgeColor($order->status) }}">
                                        {{ \App\Helpers\OrderHelper::getStatusLabel($order->status) }}
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center text-muted py-4">Bạn chưa có đơn hàng nào. <a href="{{ url('/') }}">Mua sắm ngay</a></div>
                @endif
            </div>

            <div class="card p-4 shadow-sm">
                <h5 class="mb-3">Cài đặt tài khoản</h5>
                <p class="small text-muted mb-0">Bạn có thể quản lý thông tin cá nhân, thay đổi mật khẩu và xem lịch sử đơn hàng tại đây.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Account page local styles */
    .avatar { background: linear-gradient(135deg,#f3f4f6,#e9ecef); color:#1f2937; font-weight:800 }
    .card { border-radius: 10px; }
    .list-group-item { border: none; border-bottom: 1px solid #f1f1f1; padding: 18px 20px; }
    .list-group-item:last-child { border-bottom: none }
    .list-group-item:hover { background: #fafafa }
    .fw-bold { color: #111827 }
    .text-muted { color: #6b7280 }
    .badge { font-size: 0.8rem; padding: 0.45em 0.55em }
    .card p.small { color: #6b7280 }
    @media (min-width: 992px) {
        .container.py-5 { max-width: 980px }
    }
</style>
@endpush

<footer id="footer" class="py-5 border-top bg-light" style="margin-top: 150px;">
  <div class="container-lg">
    <div class="row mb-4">
      <div class="col-lg-2 pb-4">
        <div class="footer-menu">
          <h5 class="widget-title pb-3 fw-bold">Thông tin</h5>
          <ul class="menu-list list-unstyled">
            <li class="pb-2"><a href="#" class="text-decoration-none">Theo dõi đơn hàng</a></li>
            <li class="pb-2"><a href="{{ url('/') }}" class="text-decoration-none">Blog của chúng tôi</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Chính sách bảo mật</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Giao hàng</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Liên hệ</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Trợ giúp</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Cộng đồng</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-2 pb-4">
        <div class="footer-menu">
          <h5 class="widget-title pb-3 fw-bold">Về chúng tôi</h5>
          <ul class="menu-list list-unstyled">
            <li class="pb-2"><a href="#" class="text-decoration-none">Lịch sử</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Đội ngũ</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Dịch vụ</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Công ty</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Sản xuất</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Bán sỉ</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Bán lẻ</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-2 pb-4">
        <div class="footer-menu">
          <h5 class="widget-title pb-3 fw-bold">Danh mục</h5>
          <ul class="menu-list list-unstyled">
            <li class="pb-2"><a href="{{ url('/women') }}" class="text-decoration-none">Giày nữ</a></li>
            <li class="pb-2"><a href="{{ url('/men') }}" class="text-decoration-none">Giày nam</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Giày thể thao</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Giày casual</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Giày cao gót</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Tất cả sản phẩm</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-2 pb-4">
        <div class="footer-menu">
          <h5 class="widget-title pb-3 fw-bold">Phổ biến</h5>
          <ul class="menu-list list-unstyled">
            <li class="pb-2"><a href="#" class="text-decoration-none">Sản phẩm mới</a></li>
            <li class="pb-2"><a href="#" class="text-decoration-none">Bán chạy nhất</a></li>
            <li class="pb-2"><a href="{{ route('login') }}" class="text-decoration-none">Đăng nhập</a></li>
            <li class="pb-2"><a href="#" data-bs-toggle="modal" data-bs-target="#modallong" class="text-decoration-none">Giỏ hàng</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 pb-4">
        <div class="footer-menu">
          <h5 class="widget-title pb-3 fw-bold">Liên hệ</h5>
          <div class="footer-contact-text">
            <p class="mb-2"><strong>Địa chỉ:</strong> Stylish Online Store, Yên Nghĩa, Hà Đông - Hà Nội</p>
            <p class="mb-2"><strong>Hotline:</strong> <a href="tel:+84388123456" class="text-decoration-none">(+84) 388 123 456</a></p>
            <p class="mb-0"><strong>Email:</strong> <a href="mailto:contact@stylish.com" class="text-decoration-none">contact@stylish.com</a></p>
          </div>
        </div>
      </div>
    </div>

    <div class="row py-4 border-top">
      <div class="col-md-6">
        <p class="m-0">© 2026 Stylish Store. Bản quyền được bảo lưu.</p>
      </div>
      <div class="col-md-6 text-lg-end">
        <p class="m-0">Thiết kế bởi <a href="https://stylish.com/" target="_blank" class="text-decoration-none">Stylish Team</a></p>
      </div>
    </div>
  </div>
</footer>