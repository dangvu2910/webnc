<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tài khoản của tôi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-2xl bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-semibold mb-4">Tài khoản của tôi</h1>

        <div class="space-y-2">
            <p><strong>ID:</strong> {{ auth()->user()->id }}</p>
            <p><strong>Họ và tên:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Tên đăng nhập:</strong> {{ auth()->user()->username }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Admin:</strong> {{ auth()->user()->is_admin ? 'Có' : 'Không' }}</p>
        </div>

        <div class="mt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Đăng xuất</button>
            </form>
        </div>
        <div class="mt-4">
            <a href="/index" class="inline-block px-4 py-2 bg-green-500 text-white rounded">Tiếp tục mua hàng</a>
        </div>
    </div>
</body>
</html>