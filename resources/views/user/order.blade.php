@extends('layouts.user')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container py-5">
  <div class="row">
    <div class="col-12">
      <div class="card p-4">
        <h3>Đơn hàng #{{ $order->id }}</h3>
        <p class="text-muted">Ngày: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Người nhận:</strong> {{ $order->fullname }} &nbsp; <strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
        <hr>
        <h5>Sản phẩm</h5>
        <ul class="list-group mb-3">
          @foreach($order->items as $it)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center gap-3">
                <div style="width: 60px; height: 60px; flex-shrink: 0;">
                  @php
                    // Always use demo images
                    $imageIndex = 1;
                    if (isset($it->product->sku) && preg_match('/^(men|women)-(\d+)$/', $it->product->sku, $m)) {
                      $num = (int)$m[2];
                      $imageIndex = ($num % 10) + 1;
                    } elseif ($it->product_id) {
                      $imageIndex = (($it->product_id % 10) + 1);
                    }
                    $imageUrl = asset("user/images/card-item{$imageIndex}.jpg");
                  @endphp
                  <img src="{{ $imageUrl }}" alt="{{ $it->name }}" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div>
                  <div class="fw-bold">{{ $it->name }}</div>
                  <small class="text-muted">Số lượng: {{ $it->qty }}</small>
                </div>
              </div>
              <div class="fw-bold">{{ number_format($it->total, 0, ',', '.') }} ₫</div>
            </li>
          @endforeach
        </ul>
        <div class="d-flex justify-content-end align-items-center gap-3">
          <div class="text-end">
            <div>Subtotal: {{ number_format($order->subtotal, 0, ',', '.') }} ₫</div>
            <div>Shipping: {{ number_format($order->shipping, 0, ',', '.') }} ₫</div>
            <div class="fw-bold">Total: {{ number_format($order->total, 0, ',', '.') }} ₫</div>
          </div>
        </div>
        <div class="mt-3">
          @if($order->status !== 'paid')
            <form method="POST" action="{{ url('/account/orders/'.$order->id.'/pay') }}">
              @csrf
              <button class="btn btn-primary">Thanh toán</button>
            </form>
          @else
            <span class="badge bg-success">Đã thanh toán</span>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

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
@endsection
