<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nữ - Sản phẩm</title>
  <link rel="stylesheet" href="{{ asset('user/css/vendor.css') }}">
  <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
</head>
<body>
  @include('partials.header')
  <div class="container-lg py-5">
    <h1 class="mb-4">Nữ</h1>
    <p class="lead">Khám phá bộ sưu tập giày nữ: phong cách, tiện dụng và những mẫu mới nhất với giảm giá.</p>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
      @for($i=1;$i<=9;$i++)
        <div class="col">
          <div class="product-card position-relative p-3 border rounded h-100">
            <img src="{{ asset('user/images/card-item'.((($i+3)%10)+1).'.jpg') }}" alt="sản phẩm" class="img-fluid mb-3" style="height:180px;object-fit:cover;width:100%">
            <h3 class="fs-6 mb-2">Sản phẩm nữ {{ $i }}</h3>
            <div class="d-flex justify-content-between align-items-center">
              <div class="fw-bold">$89</div>
              <form method="POST" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="id" value="women-{{ $i }}">
                <input type="hidden" name="name" value="Sản phẩm nữ {{ $i }}">
                <input type="hidden" name="price" value="89">
                <input type="hidden" name="qty" value="1">
                <button class="btn btn-sm btn-black" type="submit">Thêm vào giỏ</button>
              </form>
            </div>
          </div>
        </div>
      @endfor
    </div>
  </div>
</body>
</html>
