<!doctype html>
<html lang="en" class="h-full" x-data="{ dark: localStorage.theme === 'dark' }" x-bind:class="dark ? 'dark' : ''">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Admin')</title>
  <link rel="stylesheet" href="{{ asset('vendor/windmill/assets/css/tailwind.output.css') }}">
  @stack('styles')
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
  @includeIf('admin.partials.header')
  <div class="flex">
    @includeIf('admin.partials.sidebar')
    <main class="flex-1 p-6">
      @yield('content')
    </main>
  </div>
  @stack('scripts')
</body>
</html>
