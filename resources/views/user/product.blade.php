@extends('layouts.user')
@section('title', 'Chi tiết sản phẩm')

@section('content')
<div class="container mt-4">
  <div class="row bg-white rounded shadow p-4 g-4 align-items-start">
    <div class="col-12 col-md-6">
      <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="img-fluid rounded w-100">
    </div>

    <div class="col-12 col-md-6">
      <div class="d-flex flex-column h-100">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
          <h1 class="h4 mb-2 mb-md-0">{{ $product['name'] }}</h1>
          <p class="h5 text-danger fw-bold mb-0">${{ number_format($product['price'], 2) }}</p>
        </div>

        <p class="mb-4">{{ $product['description'] }}</p>

        <form method="POST" action="{{ url('/cart/add') }}" class="mt-auto">
          @csrf
          <input type="hidden" name="id" value="{{ $product['id'] }}">
          <input type="hidden" name="name" value="{{ $product['name'] }}">
          <input type="hidden" name="price" value="{{ $product['price'] }}">

          <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3">
            <div class="d-flex align-items-center gap-2">
              <label for="qty" class="mb-0">Số lượng</label>
              <input id="qty" name="qty" type="number" value="1" min="1" class="form-control" style="width:80px;">
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-warning fw-bold">Thêm vào giỏ</button>
              <a href="{{ url('/') }}" class="btn btn-secondary">Tiếp tục mua hàng</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection