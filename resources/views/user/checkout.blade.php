<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout - Thanh toán</title>
  <link rel="stylesheet" href="{{ asset('user/css/vendor.css') }}">
  <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
</head>
<body>
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
              <label class="form-label">Họ và tên</label>
              <input type="text" class="form-control" name="fullname" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Địa chỉ</label>
              <input type="text" class="form-control" name="address" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Phương thức thanh toán</label>
              <select class="form-control" name="payment_method">
                <option value="cod">Thanh toán khi nhận hàng</option>
                <option value="card">Thẻ ngân hàng</option>
              </select>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-black">Đặt hàng (demo)</button>
              <a href="{{ url('/index') }}" class="btn btn-outline-gray">Quay về trang chủ</a>
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
                @php $line = $item['price'] * $item['qty']; $subtotal += $line; @endphp
                <li class="d-flex justify-content-between mb-2">
                  <div>
                    <div class="fw-bold">{{ $item['name'] }}</div>
                    <div class="text-muted">Qty: {{ $item['qty'] }}</div>
                  </div>
                  <div>${{ number_format($line,2) }}</div>
                </li>
              @endforeach
            </ul>
            <div class="d-flex justify-content-between fw-bold mb-2">
              <div>Tạm tính</div>
              <div>${{ number_format($subtotal,2) }}</div>
            </div>
            <div class="d-flex justify-content-between mb-3">
              <div>Vận chuyển</div>
              <div class="text-muted">Miễn phí</div>
            </div>
            <div class="d-flex justify-content-between fw-bold mb-3">
              <div>Tổng</div>
              <div>${{ number_format($subtotal,2) }}</div>
            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Form submits to server; server will create order and redirect -->
  </div>
</body>
</html>
