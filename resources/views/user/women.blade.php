@extends('layouts.user')
@section('title', 'Sản phẩm nữ')
@section('content')

  <div class="py-5 px-4">
    <div class="container-fluid">
      <h1 class="mb-5 fw-bold text-uppercase">Giày nữ</h1>
      
      <div class="product-content">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 g-4">
          @php
            $prices = [499000, 599000, 699000, 799000, 899000];
            $names = ['Nike Dunk Low Blue', 'Nike Air Force 1', 'Nike Free RN', 'Nike Revolution', 'Nike Court Borough', 'Adidas Stan Smith', 'Adidas NMD R1', 'New Balance 990', 'Puma RS-X'];
          @endphp
          
          @for($i = 1; $i <= 9; $i++)
            @php
              $price = $prices[($i - 1) % 5];
              $name = $names[$i - 1] ?? "Sản phẩm nữ " . $i;
            @endphp
            <div class="col">
              <div class="product-card position-relative h-100">
                <div class="card-img rounded-4 overflow-hidden position-relative">
                  <a href="{{ route('product.show', 'women-'.$i) }}">
                    <img src="{{ asset('user/images/card-item'.((($i+3)%10)+1).'.jpg') }}" alt="{{ $name }}" class="product-image img-fluid w-100" style="object-fit: cover; height: 280px;">
                  </a>
                  <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                    <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                      <a href="#" data-sku="women-{{ $i }}" data-name="{{ $name }}" data-price="{{ $price }}" data-image="{{ asset('user/images/card-item'.((($i+3)%10)+1).'.jpg') }}" class="btn btn-light ajax-add-cart rounded-circle">
                        <svg class="shopping-carriage"><use xlink:href="#shopping-carriage"></use></svg>
                      </a>
                      <a href="{{ route('product.show', 'women-'.$i) }}" class="btn btn-light rounded-circle">
                        <svg class="quick-view"><use xlink:href="#quick-view"></use></svg>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                  <h3 class="card-title fs-6 fw-normal m-0">
                    <a href="{{ route('product.show', 'women-'.$i) }}" class="text-dark text-decoration-none">{{ $name }}</a>
                  </h3>
                  <span class="card-price fw-bold mt-2">{{ number_format($price, 0, ',', '.') }} ₫</span>
                </div>
              </div>
            </div>
          @endfor
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

  @include('partials.add_toast')

@endsection
