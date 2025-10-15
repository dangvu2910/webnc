<!-- Desktop sidebar -->
<aside class="z-20 flex-shrink-0 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block">
  <div class="py-4 text-gray-500 dark:text-gray-400">
    <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="{{ url('admin') }}">
      Stylish Admin
    </a>

    <!-- Dashboard -->
    <ul class="mt-6">
      <li class="relative px-6 py-3">
        @if(request()->is('admin') || request()->is('admin/dashboard'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold {{ request()->is('admin') || request()->is('admin/dashboard') ? 'text-gray-800 dark:text-gray-100' : '' }} transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" 
           href="{{ url('admin') }}">
          <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
          </svg>
          <span class="ml-4">Dashboard</span>
        </a>
      </li>
    </ul>

    <!-- USER Section -->
    <div class="px-6 my-4">
      <span class="text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">USER</span>
    </div>
    <ul>
      <li class="relative px-6 py-3">
        @if(request()->is('admin/users'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold {{ request()->is('admin/users') ? 'text-gray-800 dark:text-gray-100' : '' }} transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" 
           href="{{ route('admin.users.index') }}">
          <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
          </svg>
          <span class="ml-4">Users</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        @if(request()->is('admin/users/create'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold {{ request()->is('admin/users/create') ? 'text-gray-800 dark:text-gray-100' : '' }} transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" 
           href="{{ route('admin.users.create') }}">
          <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
          </svg>
          <span class="ml-4">Add User</span>
        </a>
      </li>
    </ul>

    <!-- PRODUCT Section -->
    <div class="px-6 my-4">
      <span class="text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">PRODUCT</span>
    </div>
    <ul>
      <li class="relative px-6 py-3">
        @if(request()->is('admin/products') && !request()->is('admin/products/create'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold {{ request()->is('admin/products') && !request()->is('admin/products/create') ? 'text-gray-800 dark:text-gray-100' : '' }} transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" 
           href="{{ route('admin.products.index') }}">
          <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
          </svg>
          <span class="ml-4">Products</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        @if(request()->is('admin/products/create'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold {{ request()->is('admin/products/create') ? 'text-gray-800 dark:text-gray-100' : '' }} transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" 
           href="{{ route('admin.products.create') }}">
          <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <span class="ml-4">Add Product</span>
        </a>
      </li>
    </ul>

    <!-- CATEGORY Section -->
    <div class="px-6 my-4">
      <span class="text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">CATEGORY</span>
    </div>
    <ul>
      <li class="relative px-6 py-3">
        @if(request()->is('admin/categories') && !request()->is('admin/categories/create'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold {{ request()->is('admin/categories') && !request()->is('admin/categories/create') ? 'text-gray-800 dark:text-gray-100' : '' }} transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" 
           href="{{ route('admin.categories.index') }}">
          <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
          </svg>
          <span class="ml-4">Categories</span>
        </a>
      </li>
      <li class="relative px-6 py-3">
        @if(request()->is('admin/categories/create'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold {{ request()->is('admin/categories/create') ? 'text-gray-800 dark:text-gray-100' : '' }} transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" 
           href="{{ route('admin.categories.create') }}">
          <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <span class="ml-4">Add Category</span>
        </a>
      </li>
    </ul>

    <!-- ORDER Section -->
    <div class="px-6 my-4">
      <span class="text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">ORDER</span>
    </div>
    <ul>
      <li class="relative px-6 py-3">
        @if(request()->is('admin/orders*'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold {{ request()->is('admin/orders*') ? 'text-gray-800 dark:text-gray-100' : '' }} transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" 
           href="{{ route('admin.orders.index') }}">
          <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
          <span class="ml-4">Orders</span>
        </a>
      </li>
    </ul>

    <!-- Keep existing menu items -->
    <div class="px-6 my-4">
      <span class="text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">KHÁC</span>
    </div>
    <ul>
      <li class="relative px-6 py-3">
        @if(request()->is('admin/charts'))
          <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
        @endif
        <a class="inline-flex items-center w-full text-sm font-semibold {{ request()->is('admin/charts') ? 'text-gray-800 dark:text-gray-100' : '' }} transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" 
           href="{{ url('admin/charts') }}">
          <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
            <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
          </svg>
          <span class="ml-4">Biểu đồ</span>
        </a>
      </li>

      <!-- Pages submenu -->
      <li class="relative px-6 py-3">
        <button class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" 
                @click="togglePagesMenu" 
                aria-haspopup="true">
          <span class="inline-flex items-center">
            <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
              <path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
            </svg>
            <span class="ml-4">Trang</span>
          </span>
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
          </svg>
        </button>
        <template x-if="isPagesMenuOpen">
          <ul class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900">
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="{{ url('admin/pages/login') }}">Login</a>
            </li>
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="{{ url('admin/pages/create-account') }}">Đăng ký</a>
            </li>
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="{{ url('admin/pages/forgot-password') }}">Quên mật khẩu</a>
            </li>
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="{{ url('admin/pages/404') }}">404</a>
            </li>
            <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
              <a class="w-full" href="{{ url('admin/pages/blank') }}">Trang trống</a>
            </li>
          </ul>
        </template>
      </li>
    </ul>
  </div>
</aside>
