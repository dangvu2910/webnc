@extends('layouts.user')

@section('title', 'Trang chủ')

@section('content')
  <section id="intro" class="position-relative">
    <div class="container-lg">
      <div class="swiper main-swiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="card d-flex flex-row align-items-end border-0 large jarallax-keep-img">
              <img src="{{ asset('user/images/banner1.png') }}" alt="Banner 1" class="img-fluid jarallax-img">
              <div class="cart-concern p-3 m-3 p-lg-5 m-lg-5">
                <h2 class="card-title display-3 light">Banner 1</h2>
                <p class="light mb-3">Bộ sưu tập mới nhất với công nghệ tiên tiến</p>
                <a href="#" class="text-uppercase light mt-3 d-inline-block text-hover fw-bold light-border">Khám phá ngay</a>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card d-flex flex-row align-items-end border-0 large jarallax-keep-img">
              <img src="{{ asset('user/images/banner3.png') }}" alt="Banner 2" class="img-fluid jarallax-img">
              <div class="cart-concern p-3 m-3 p-lg-5 m-lg-5">
                <h2 class="card-title display-3 light">Banner 2</h2>
                <p class="light mb-3">Chất lượng tốt nhất, giá cả hợp lý</p>
                <a href="#" class="text-uppercase light mt-3 d-inline-block text-hover fw-bold light-border">Khám phá ngay</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </section>

  <section class="discount-coupon py-3 px-4">
    <div class="container-fluid">
      <div class="bg-gray coupon position-relative p-5 rounded-4">
        <div class="bold-text position-absolute">Giảm 10%</div>
        <div class="row justify-content-between align-items-center">
          <div class="col-lg-7 col-md-12 mb-3">
            <div class="coupon-header">
              <h2 class="display-7 fw-bold mb-2">Mã giảm 10%</h2>
              <p class="m-0 text-muted">Đăng ký để nhận mã giảm 10% cho mọi đơn hàng</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-12">
            <div class="btn-wrap">
              <a href="#" class="btn btn-black btn-medium text-uppercase hvr-sweep-to-right">Gửi Email</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="featured-products" class="product-store py-3 px-4">
    <div class="container-fluid">
      <div class="display-header d-flex align-items-center justify-content-between mb-5">
        <h2 class="section-title text-uppercase fw-bold">Sản phẩm nổi bật</h2>
        <div class="btn-right">
          <a href="index.html" class="d-inline-block text-uppercase text-hover fw-bold">Xem tất cả →</a>
        </div>
      </div>
      <div class="product-content">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
          @if(!empty($products) && count($products))
            @foreach($products->take(5) as $product)
              @php
                $id = $product->sku ?? $product->id;
                $title = $product->name ?? 'Sản phẩm';
                $price = $product->price ?? 0;
                // Always use demo images based on product SKU or ID
                $imageIndex = 1;
                if ($id && preg_match('/^(men|women)-(\d+)$/', (string)$id, $m)) {
                  $num = (int)$m[2];
                  $imageIndex = ($num % 10) + 1;
                } else {
                  $imageIndex = (($product->id % 10) + 1);
                }
                $image = asset("user/images/card-item{$imageIndex}.jpg");
              @endphp
              <div class="col">
                <div class="product-card position-relative h-100">
                  <div class="card-img rounded-4 overflow-hidden position-relative">
                    <a href="{{ route('product.show', $id) }}">
                      <img src="{{ $image }}" alt="product-item" class="product-image img-fluid w-100" style="object-fit: cover; height: 280px;">
                    </a>
                    <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                      <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                        <a href="#" data-sku="{{ $id }}" data-name="{{ e($title) }}" data-price="{{ $price }}" data-image="{{ $image }}" class="btn btn-light ajax-add-cart rounded-circle">
                          <svg class="shopping-carriage"><use xlink:href="#shopping-carriage"></use></svg>
                        </a>
                        <a href="{{ route('product.show', $id) }}" class="btn btn-light rounded-circle">
                          <svg class="quick-view"><use xlink:href="#quick-view"></use></svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                    <h3 class="card-title fs-6 fw-normal m-0">
                      <a href="{{ route('product.show', $id) }}" class="text-dark text-decoration-none">{{ $title }}</a>
                    </h3>
                    <span class="card-price fw-bold mt-2">{{ number_format($price, 0, ',', '.') }} ₫</span>
                  </div>
                </div>
              </div>
            @endforeach
          @else
            <div class="col">No products available.</div>
          @endif
        </div>
      </div>
    </div>
  </section>

  <section id="latest-products" class="product-store py-3 px-4">
    <div class="container-fluid">
      <div class="display-header d-flex align-items-center justify-content-between mb-5">
        <h2 class="section-title text-uppercase fw-bold">Sản phẩm mới</h2>
        <div class="btn-right">
          <a href="index.html" class="d-inline-block text-uppercase text-hover fw-bold">Xem tất cả →</a>
        </div>
      </div>
      <div class="product-content">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
          <div class="col">
            <div class="product-card position-relative h-100">
              <div class="card-img rounded-4 overflow-hidden position-relative">
                <a href="{{ url('/product/p6') }}">
                  <img src="{{ asset('user/images/card-item6.jpg') }}" alt="product-item" class="product-image img-fluid w-100" style="object-fit: cover; height: 280px;">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="{{ url('/product/p6') }}" class="btn btn-light rounded-circle">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p6') }}" class="btn btn-light rounded-circle">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p6') }}" class="text-dark text-decoration-none">Adidas Stan Smith</a>
                </h3>
                <span class="card-price fw-bold mt-2">{{ number_format(499000, 0, ',', '.') }} ₫</span>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="product-card position-relative h-100">
              <div class="card-img rounded-4 overflow-hidden position-relative">
                <a href="{{ url('/product/p7') }}">
                  <img src="{{ asset('user/images/card-item7.jpg') }}" alt="product-item" class="product-image img-fluid w-100" style="object-fit: cover; height: 280px;">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="{{ url('/product/p7') }}" class="btn btn-light rounded-circle">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p7') }}" class="btn btn-light rounded-circle">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p7') }}" class="text-dark text-decoration-none">Adidas NMD R1</a>
                </h3>
                <span class="card-price fw-bold mt-2">{{ number_format(599000, 0, ',', '.') }} ₫</span>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="product-card position-relative h-100">
              <div class="card-img rounded-4 overflow-hidden position-relative">
                <a href="{{ url('/product/p8') }}">
                  <img src="{{ asset('user/images/card-item8.jpg') }}" alt="product-item" class="product-image img-fluid w-100" style="object-fit: cover; height: 280px;">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="{{ url('/product/p8') }}" class="btn btn-light rounded-circle">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p8') }}" class="btn btn-light rounded-circle">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p8') }}" class="text-dark text-decoration-none">New Balance 990</a>
                </h3>
                <span class="card-price fw-bold mt-2">{{ number_format(699000, 0, ',', '.') }} ₫</span>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="product-card position-relative h-100">
              <div class="card-img rounded-4 overflow-hidden position-relative">
                <a href="{{ url('/product/p9') }}">
                  <img src="{{ asset('user/images/card-item9.jpg') }}" alt="product-item" class="product-image img-fluid w-100" style="object-fit: cover; height: 280px;">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="{{ url('/product/p9') }}" class="btn btn-light rounded-circle">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p9') }}" class="btn btn-light rounded-circle">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p9') }}" class="text-dark text-decoration-none">Puma RS-X Reinvention</a>
                </h3>
                <span class="card-price fw-bold mt-2">{{ number_format(799000, 0, ',', '.') }} ₫</span>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="product-card position-relative h-100">
              <div class="card-img rounded-4 overflow-hidden position-relative">
                <a href="{{ url('/product/p10') }}">
                  <img src="{{ asset('user/images/card-item10.jpg') }}" alt="product-item" class="product-image img-fluid w-100" style="object-fit: cover; height: 280px;">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="{{ url('/product/p10') }}" class="btn btn-light rounded-circle">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p10') }}" class="btn btn-light rounded-circle">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p10') }}" class="text-dark text-decoration-none">New Balance 574</a>
                </h3>
                <span class="card-price fw-bold mt-2">{{ number_format(599000, 0, ',', '.') }} ₫</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

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
            <ul class="menu-list list-unstyled">
