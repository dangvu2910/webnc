<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $product['name'] }}</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
  <div class="max-w-4xl mx-auto bg-white rounded shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="w-full rounded">
      </div>
      <div>
        <h1 class="text-2xl font-bold mb-2">{{ $product['name'] }}</h1>
        <p class="text-xl text-red-600 font-bold mb-4">${{ number_format($product['price'], 2) }}</p>
        <p class="mb-6">{{ $product['description'] }}</p>

        <form method="POST" action="{{ url('/cart/add') }}">
          @csrf
          <input type="hidden" name="id" value="{{ $product['id'] }}">
          <input type="hidden" name="name" value="{{ $product['name'] }}">
          <input type="hidden" name="price" value="{{ $product['price'] }}">

          <label for="qty" class="block mb-2">Số lượng</label>
          <input id="qty" name="qty" type="number" value="1" min="1" class="w-24 p-2 border rounded mb-4">

          <div class="flex items-center gap-3">
            <button type="submit" class="px-4 py-2 bg-yellow-400 font-bold rounded">Thêm vào giỏ</button>
            <a href="{{ url('/') }}" class="px-4 py-2 bg-gray-200 rounded">Tiếp tục mua hàng</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>