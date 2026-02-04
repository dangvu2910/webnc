@extends('layouts.user')
@section('title', 'Chi tiết sản phẩm')

@section('content')
@php
  // Accept either an array (from controller->toArray()) or a model instance
  $prod = is_array($product) ? $product : (is_object($product) ? (method_exists($product, 'toArray') ? $product->toArray() : (array)$product) : (array)$product);
  $prodPrice = (float)($prod['price'] ?? ($product->price ?? 599000)); // Mặc định giá giày 599.000 ₫
  $salePrice = (float)($prod['sale_price'] ?? null); // Giá khuyến mãi nếu có
@endphp
<div class="container mt-4">
  <div class="row bg-white rounded shadow p-4 g-4 align-items-start">
    <div class="col-12 col-md-6">
      @php 
        // Always use demo images based on product SKU or ID
        $imageIndex = 1;
        $id = $prod['id'] ?? $prod['sku'] ?? null;
        if ($id && preg_match('/^(men|women)-(\d+)$/', (string)$id, $m)) {
          $num = (int)$m[2];
          $imageIndex = ($num % 10) + 1;
        } elseif ($id && is_numeric($id)) {
          $imageIndex = (($id % 10) + 1);
        }
        $prodImg = asset("user/images/card-item{$imageIndex}.jpg");
      @endphp
      <img src="{{ $prodImg }}" alt="{{ $prod['name'] ?? '' }}" class="img-fluid rounded w-100">
    </div>

    <div class="col-12 col-md-6">
      <div class="d-flex flex-column h-100">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
          <div>
            <h1 class="h4 mb-2">{{ $prod['name'] ?? '' }}</h1>
            
            <!-- Brand & Material Badges -->
            @if(($prod['brand'] ?? null) || ($prod['material'] ?? null))
              <div class="mb-2">
                @if($prod['brand'] ?? null)
                  <span class="badge bg-info">{{ $prod['brand'] }}</span>
                @endif
                @if($prod['material'] ?? null)
                  <span class="badge bg-light text-dark">{{ $prod['material'] }}</span>
                @endif
              </div>
            @endif
          </div>
          <div class="d-flex align-items-center gap-2">
            @if($salePrice)
              <p class="h5 text-danger fw-bold mb-0">{{ number_format($salePrice, 0, ',', '.') }} ₫</p>
              <p class="h6 text-muted mb-0"><del>{{ number_format($prodPrice, 0, ',', '.') }} ₫</del></p>
            @else
              <p class="h5 text-danger fw-bold mb-0">{{ number_format($prodPrice, 0, ',', '.') }} ₫</p>
            @endif
          </div>
        </div>

        <!-- Rating -->
        @if($prod['rating'] ?? 0 > 0)
          <div class="mb-3">
            <div class="d-flex align-items-center gap-2">
              @for($i = 1; $i <= 5; $i++)
                <span class="text-warning">
                  @if($i <= floor($prod['rating']))
                    ★
                  @elseif($i - 0.5 <= $prod['rating'])
                    ★
                  @else
                    ☆
                  @endif
                </span>
              @endfor
              <span class="text-muted small">({{ $prod['reviews_count'] ?? 0 }} đánh giá)</span>
            </div>
          </div>
        @endif

        <!-- Stock Status -->
        @if(($prod['stock'] ?? 0) > 0)
          <div class="alert alert-success py-2 mb-3">✓ Còn hàng ({{ $prod['stock'] }} sản phẩm)</div>
        @else
          <div class="alert alert-danger py-2 mb-3">✗ Hết hàng</div>
        @endif

        <p class="mb-4">{{ $prod['description'] ?? '' }}</p>

        <!-- Shoe Information -->
        <div class="mb-4 p-3 bg-light rounded">
          <h6 class="fw-bold"> Thông tin về giày</h6>
          <ul class="mb-0 small text-muted">
            <li>Chất liệu: Được làm từ các vật liệu cao cấp, bền bỉ</li>
            <li>Kiểu dáng: Thời trang, phù hợp cho cả nam và nữ</li>
            <li>Độ thoải mái: Lót êm, thiết kế ergonomic giúp giảm mệt mỏi</li>
            <li>Độ bền: Đế chống trơn trượt, tính năng chống mài mòn</li>
            <li>Quy cách: Có nhiều kích cỡ và màu sắc lựa chọn</li>
          </ul>
        </div>

        <!-- Specifications -->
        @if($prod['specifications'] ?? null)
          <div class="mb-4 p-3 bg-light rounded">
            <h6 class="fw-bold">Thông số kỹ thuật</h6>
            <p class="text-muted small mb-0">{{ $prod['specifications'] }}</p>
          </div>
        @endif

        <!-- Warranty -->
        @if($prod['warranty'] ?? null)
          <div class="mb-4 p-3 bg-light rounded">
            <h6 class="fw-bold">Bảo hành</h6>
            <p class="text-muted small mb-0">{{ $prod['warranty'] }}</p>
          </div>
        @endif

        <!-- Care Instructions -->
        @if($prod['care_instructions'] ?? null)
          <div class="mb-4 p-3 bg-light rounded">
            <h6 class="fw-bold">Hướng dẫn bảo quản</h6>
            <p class="text-muted small mb-0">{{ $prod['care_instructions'] }}</p>
          </div>
        @endif

        <form method="POST" action="{{ url('/cart/add') }}" class="mt-auto">
          @csrf
          <input type="hidden" name="id" value="{{ $prod['id'] ?? ($prod['sku'] ?? '') }}">
          <input type="hidden" name="name" value="{{ $prod['name'] ?? '' }}">
          <input type="hidden" name="price" value="{{ $prodPrice }}">

          <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3">
            <div class="d-flex align-items-center gap-2">
              <label for="qty" class="mb-0">Số lượng</label>
              <input id="qty" name="qty" type="number" value="1" min="1" max="{{ $prod['stock'] ?? 1 }}" class="form-control" style="width:80px;">
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-warning fw-bold" @if(($prod['stock'] ?? 0) <= 0) disabled @endif>
                @if(($prod['stock'] ?? 0) > 0)
                  Thêm vào giỏ
                @else
                  Hết hàng
                @endif
              </button>
              <a href="{{ url('/') }}" class="btn btn-secondary">Tiếp tục mua hàng</a>
            </div>
          </div>
        </form>
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