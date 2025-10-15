<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin') - Stylish Admin</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('vendor/admin/assets/css/tailwind.output.css') }}" />
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="{{ asset('vendor/admin/assets/js/init-alpine.js') }}"></script>
    @stack('head')
  </head>
  <body>
    <div
      class="flex h-screen bg-gray-50 dark:bg-gray-900"
      :class="{ 'overflow-hidden': isSideMenuOpen }"
    >
      {{-- sidebar partial (desktop + mobile handled inside) --}}
      @include('partials.admin-sidebar')

      <div class="flex flex-col flex-1 w-full">
        {{-- header --}}
        <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
          <div
            class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300"
          >
            <button
              class="p-1 -ml-1 mr-5 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
              @click="toggleSideMenu"
              aria-label="Menu"
            >
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
              </svg>
            </button>
            <div class="flex justify-center flex-1 lg:mr-32">
              {{-- page title could be here if desired --}}
            </div>

            <ul class="flex items-center flex-shrink-0 space-x-6">
              {{-- optional top-right items (notifications/profile) from original theme --}}
            </ul>
          </div>
        </header>

        <main class="h-full pb-16 overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            @yield('content')
          </div>
        </main>
      </div>
    </div>

    @stack('scripts')
  </body>
</html>
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
