<form id="login-form" method="POST" action="{{ url('login') }}" class="space-y-4">
    @csrf

    @if (session('status'))
        <div class="mb-4 p-3 bg-green-50 border border-green-100 text-green-700 rounded">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <label for="login" class="block text-sm font-medium text-gray-700">Tên đăng nhập hoặc Email</label>
        <input id="login" name="login" type="text" value="{{ old('login') }}" required autofocus
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
        <input id="password" name="password" type="password" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember" name="remember" type="checkbox" class="mr-2">
            <label for="remember" class="text-sm text-gray-600">Ghi nhớ</label>
        </div>
        <a href="{{ url('register') }}" class="text-sm text-indigo-600 hover:underline">Tạo tài khoản</a>
    </div>

    <div>
        <button type="submit" class="w-full px-4 py-3 bg-yellow-400 text-gray-900 font-black rounded-lg shadow-md hover:bg-yellow-500">Đăng nhập</button>
    </div>
</form>
