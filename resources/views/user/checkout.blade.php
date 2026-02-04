@extends('layouts.user')
@section('title', 'Thanh toán')

@section('content')
  <div class="container-lg py-5">
    <h1 class="mb-4">Thanh toán</h1>

    @if(session('status'))
      <div class="mb-4 p-3 bg-green-50 border border-green-100 text-green-700 rounded">{{ session('status') }}</div>
    @endif

    <div class="row">
      <div class="col-md-7">
        <div class="card p-4 mb-4">
          <h3 class="h5 mb-3">Thông tin người nhận</h3>
          <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="fullname" 
                     placeholder="Nhập họ và tên của bạn" 
                     title="Vui lòng nhập họ và tên" 
                     required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" class="form-control" name="email" 
                     placeholder="Nhập địa chỉ email của bạn" 
                     title="Vui lòng nhập email hợp lệ" 
                     required>
            </div>
            <div class="mb-3">
              <label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="address" 
                     placeholder="Nhập địa chỉ giao hàng đầy đủ" 
                     title="Vui lòng nhập địa chỉ giao hàng" 
                     required>
            </div>
            <div class="mb-3">
              <label class="form-label">Phương thức thanh toán</label>
              <select id="payment-method" class="form-control" name="payment_method">
                <option value="cod">Thanh toán khi nhận hàng</option>
                <option value="card">Thẻ ngân hàng</option>
              </select>
            </div>

            <div id="bank-pay-block" class="mb-3" style="display:none;">
              <label class="form-label">Quét mã QR để thanh toán bằng thẻ ngân hàng</label>
              <div class="card p-3" style="max-width:260px;border-radius:8px;">
                <img src="{{ asset('user/images/qr.jpg') }}" alt="QR Bank" style="width:100%;height:auto;border-radius:6px;display:block;margin-bottom:10px;">
              </div>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-black">Đặt hàng</button>
              <a href="{{ url('/') }}" class="btn btn-outline-gray">Quay về trang chủ</a>
            </div>
          </form>
        </div>
      </div>

      <div class="col-md-5">
        <div class="card p-4">
          <h3 class="h5 mb-3">Tóm tắt đơn hàng</h3>
          @php $subtotal = 0; $cart = session('cart') ?? []; @endphp
          @if(count($cart) === 0)
            <p>Giỏ hàng trống.</p>
          @else
            <ul class="list-unstyled mb-3">
              @foreach($cart as $item)
        @php
          $line = $item['price'] * $item['qty'];
          $subtotal += $line;
          // Resolve image inline (supports session-stored image, uploaded 'products/' storage paths, and demo ids)
          $img = null;
          if (is_array($item) && array_key_exists('image', $item) && $item['image']) {
            if (str_starts_with($item['image'], 'products/')) {
              $img = \Illuminate\Support\Facades\Storage::url($item['image']);
            } else {
              $img = asset($item['image']);
            }
          } else {
            try {
              $lookupId = $item['id'] ?? null;
              $product = null;
              if ($lookupId) {
                if (!is_numeric($lookupId)) {
                  $product = \App\Models\Product::where('sku', $lookupId)->orWhere('slug', $lookupId)->first();
                } else {
                  $product = \App\Models\Product::find($lookupId);
                }
              }

              if ($product && !empty($product->image)) {
                if (str_starts_with($product->image, 'products/')) {
                  $img = \Illuminate\Support\Facades\Storage::url($product->image);
                } else {
                  $img = asset($product->image);
                }
              } else {
                if (is_string($lookupId) && preg_match('/^(men|women)-(\d+)$/', $lookupId, $m)) {
                  $num = (int) $m[2];
                  $imageIndex = ($num % 10) + 1;
                  $img = asset("user/images/card-item{$imageIndex}.jpg");
                }
              }
            } catch (\Throwable $e) {
              $img = null;
            }
          }
          $img = $img ?? asset('user/images/card-item1.jpg');
        @endphp
                <li class="d-flex justify-content-between align-items-center mb-3">
                  <div class="d-flex align-items-center">
                    <img src="{{ $img }}" alt="{{ $item['name'] }}" style="width:60px;height:60px;object-fit:cover;border-radius:6px;margin-right:12px;">
                    <div>
                      <div class="fw-bold">{{ $item['name'] }}</div>
                      <div class="text-muted">Qty: {{ $item['qty'] }}</div>
                    </div>
                  </div>
                  <div>{{ number_format($line, 0, ',', '.') }} ₫</div>
                </li>
              @endforeach
            </ul>
            <div class="d-flex justify-content-between fw-bold mb-2">
              <div>Tạm tính</div>
              <div>{{ number_format($subtotal, 0, ',', '.') }} ₫</div>
            </div>
            <div class="d-flex justify-content-between mb-3">
              <div>Vận chuyển</div>
              <div class="text-muted">Miễn phí</div>
            </div>
            <div class="d-flex justify-content-between fw-bold mb-3">
              <div>Tổng</div>
              <div>{{ number_format($subtotal, 0, ',', '.') }} ₫</div>
            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Form submits to server; server will create order and redirect -->
  </div>
@endsection

@push('scripts')
<script>
  (function(){
    var sel = document.getElementById('payment-method');
    var block = document.getElementById('bank-pay-block');
    if(!sel || !block) return;
    function update(){
      if(sel.value === 'card') block.style.display = '';
      else block.style.display = 'none';
    }
    sel.addEventListener('change', update);
    // init
    update();
  })();
</script>
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
