@extends('layouts.user')
@section('title', 'Giỏ hàng của bạn')

@section('content')
<div class="container-lg py-5">
  <h1 class="mb-4">Giỏ hàng của bạn</h1>

  @if(session('cart') && count(session('cart')))
    <div class="cart-wrapper d-flex gap-4">
      <div class="cart-items flex-grow-1">
        @foreach(session('cart') as $item)
          <div class="cart-item d-flex align-items-center justify-content-between border-bottom py-3">
            <div class="d-flex align-items-center">
        @php
        $img = \App\Helpers\ImageHelper::productImageUrl($item['image'] ?? null, null, $item['id'] ?? null);
        @endphp
        <img src="{{ $img }}" alt="{{ $item['name'] }}" style="width:80px;height:80px;object-fit:cover;border-radius:6px;margin-right:16px;">
              <div>
                <div class="fw-bold">{{ $item['name'] }}</div>
                <div class="text-muted">SKU: {{ $item['id'] }}</div>
              </div>
            </div>

            <div class="d-flex align-items-center">
              <form method="POST" action="{{ route('cart.update') }}" style="display:inline-flex;align-items:center;">
                @csrf
                <input type="hidden" name="id" value="{{ $item['id'] }}">
                <button type="button" onclick="this.parentElement.querySelector('input[name=qty]').stepDown();" class="btn btn-light" style="padding:6px 10px;">-</button>
                <input type="number" name="qty" value="{{ $item['qty'] }}" min="0" style="width:60px;text-align:center;margin:0 8px;padding:6px;border:1px solid #eee;border-radius:6px;">
                <button type="button" onclick="this.parentElement.querySelector('input[name=qty]').stepUp();" class="btn btn-light" style="padding:6px 10px;">+</button>
                <button class="btn btn-sm btn-black ms-2" type="submit">Cập nhật</button>
              </form>
              <div style="width:120px;text-align:right;margin-left:24px;">
                <div class="fw-bold">{{ number_format($item['price'] * $item['qty'], 0, ',', '.') }} ₫</div>
                <form method="POST" action="{{ route('cart.remove') }}">
                  @csrf
                  <input type="hidden" name="id" value="{{ $item['id'] }}">
                  <button class="btn btn-sm btn-outline-gray mt-2" type="submit">Xóa</button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <aside class="cart-summary mt-4 p-3 border rounded" style="max-width:360px;">
        <h3 class="h5 mb-3">Tóm tắt đơn hàng</h3>
        @php $subtotal = 0; @endphp
        @foreach(session('cart') as $item)
          @php $subtotal += $item['price'] * $item['qty']; @endphp
        @endforeach
        <div class="d-flex justify-content-between mb-2">
          <div>Tạm tính</div>
          <div class="fw-bold">{{ number_format($subtotal, 0, ',', '.') }} ₫</div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>Vận chuyển</div>
          <div class="text-muted">Miễn phí</div>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <div>Tổng</div>
          <div class="fw-bold">{{ number_format($subtotal, 0, ',', '.') }} ₫</div>
        </div>

        <div class="d-flex gap-2">
          <a href="{{ url('/checkout') }}" class="btn btn-black w-100">Tiến hành thanh toán</a>
        </div>

        <div class="d-flex gap-2 mt-3">
          <form method="POST" action="{{ route('cart.clear') }}" style="flex:1;">
            @csrf
            <button type="submit" class="btn btn-outline-gray w-100">Xóa giỏ hàng</button>
          </form>
          <a href="{{ route('cart.add.sample') }}" class="btn btn-outline-gray" style="width:120px;">Thêm mẫu</a>
        </div>
      </aside>
    </div>
  @else
    <p>Giỏ hàng trống.</p>
    <a href="{{ url('/') }}" class="btn btn-outline-gray">Tiếp tục mua sắm</a>
  @endif
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
