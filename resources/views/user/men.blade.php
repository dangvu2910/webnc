<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nam - Sản phẩm</title>
  <link rel="stylesheet" href="{{ asset('user/css/vendor.css') }}">
  <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
</head>
<body>
  @include('partials.header')
  <div class="container-lg py-5">
    <h1 class="mb-4">Nam</h1>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
      @for($i=1;$i<=9;$i++)
        <div class="col">
          <div class="product-card position-relative p-3 border rounded h-100">
            <img src="{{ asset('user/images/card-item'.(($i%10)+1).'.jpg') }}" alt="sản phẩm" class="img-fluid mb-3" style="height:180px;object-fit:cover;width:100%">
            <h3 class="fs-6 mb-2">Sản phẩm nam {{ $i }}</h3>
            <div class="d-flex justify-content-between align-items-center">
              <div class="fw-bold">$99</div>
              <form method="POST" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="id" value="men-{{ $i }}">
                <input type="hidden" name="name" value="Sản phẩm nam {{ $i }}">
                <input type="hidden" name="price" value="99">
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
