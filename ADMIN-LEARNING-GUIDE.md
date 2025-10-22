# 📚 HƯỚNG DẪN HỌC ADMIN PANEL - TOÀN DIỆN

## 🎯 MỤC TIÊU HỌC TẬP

Sau khi học xong, bạn sẽ:
- ✅ Hiểu rõ luồng xử lý từ Route → Controller → Model → View
- ✅ Biết cách CRUD (Create, Read, Update, Delete)
- ✅ Hiểu quan hệ Database (1-1, 1-n, n-n)
- ✅ Làm chủ Blade Template
- ✅ Validation và xử lý lỗi
- ✅ Upload file/ảnh
- ✅ Phân quyền Admin

---

## 📋 NỘI DUNG HỌC TẬP

### **1. KIẾN TRÚC MVC**

```
REQUEST (URL: /admin/products)
    ↓
ROUTE (routes/web.php)
    → Route::get('admin/products', [ProductController::class, 'index'])
    ↓
MIDDLEWARE (IsAdmin.php)
    → Kiểm tra user có quyền admin không?
    ↓
CONTROLLER (ProductController@index)
    → Lấy dữ liệu từ Model
    ↓
MODEL (Product::with('category')->paginate(15))
    → Query database
    ↓
VIEW (admin.products.index.blade.php)
    → Hiển thị HTML
    ↓
RESPONSE (HTML trả về browser)
```

---

### **2. ROUTES - CÁC LOẠI HTTP METHOD**

| Method | URL | Action | Mục đích |
|--------|-----|--------|----------|
| GET | `/admin/products` | `index()` | Xem danh sách |
| GET | `/admin/products/create` | `create()` | Form thêm mới |
| POST | `/admin/products` | `store()` | Lưu dữ liệu mới |
| GET | `/admin/products/5/edit` | `edit(5)` | Form chỉnh sửa |
| PUT | `/admin/products/5` | `update(5)` | Cập nhật |
| DELETE | `/admin/products/5` | `destroy(5)` | Xóa |

**Ví dụ đầy đủ Routes:**

```php
Route::prefix('admin')->middleware(['auth','is_admin'])->group(function () {
    // Products CRUD
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/create', [ProductController::class, 'create']);
    Route::post('products', [ProductController::class, 'store']);
    Route::get('products/{product}/edit', [ProductController::class, 'edit']);
    Route::put('products/{product}', [ProductController::class, 'update']);
    Route::delete('products/{product}', [ProductController::class, 'destroy']);
});
```

---

### **3. CONTROLLER - XỬ LÝ LOGIC**

#### **3.1 Lấy danh sách (index)**

```php
public function index()
{
    // Query database
    $products = Product::with('category')  // Eager load category
                       ->latest()          // Mới nhất trước
                       ->paginate(15);     // 15 items/page
    
    // Trả về view
    return view('admin.products.index', compact('products'));
}
```

**Giải thích:**
- `Product::` - Gọi Model Product
- `with('category')` - Load luôn category (tránh N+1 query)
- `latest()` - `ORDER BY created_at DESC`
- `paginate(15)` - Tự động tạo pagination links

---

#### **3.2 Hiển thị form thêm mới (create)**

```php
public function create()
{
    // Lấy tất cả categories cho dropdown
    $categories = Category::all();
    
    return view('admin.products.create', compact('categories'));
}
```

---

#### **3.3 Lưu dữ liệu (store)**

```php
public function store(Request $request)
{
    // 1. VALIDATE
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|max:2048',
    ]);

    // 2. TẠO SLUG
    $validated['slug'] = Str::slug($request->name);

    // 3. UPLOAD ẢNH
    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    // 4. TẠO RECORD
    Product::create($validated);

    // 5. REDIRECT + MESSAGE
    return redirect()->route('admin.products.index')
                     ->with('success', 'Đã tạo thành công!');
}
```

**Validation Rules:**

| Rule | Ý nghĩa |
|------|---------|
| `required` | Bắt buộc |
| `nullable` | Không bắt buộc |
| `string` | Phải là text |
| `numeric` | Phải là số |
| `integer` | Số nguyên |
| `min:X` | Giá trị tối thiểu |
| `max:X` | Giá trị tối đa |
| `email` | Email hợp lệ |
| `unique:table,column` | Duy nhất trong DB |
| `exists:table,column` | Phải tồn tại trong DB |
| `image` | File ảnh |
| `confirmed` | Xác nhận password |

---

#### **3.4 Hiển thị form sửa (edit)**

```php
public function edit(Product $product)
{
    // Route Model Binding tự động tìm Product theo ID
    // Không tìm thấy → 404
    
    $categories = Category::all();
    
    return view('admin.products.edit', compact('product', 'categories'));
}
```

---

#### **3.5 Cập nhật (update)**

```php
public function update(Request $request, Product $product)
{
    // Validate
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        // ...
    ]);

    // Tạo slug
    $validated['slug'] = Str::slug($request->name);

    // Upload ảnh mới (nếu có)
    if ($request->hasFile('image')) {
        // Xóa ảnh cũ
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        // Upload ảnh mới
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    // Cập nhật
    $product->update($validated);

    return redirect()->route('admin.products.index')
                     ->with('success', 'Đã cập nhật!');
}
```

---

#### **3.6 Xóa (destroy)**

```php
public function destroy(Product $product)
{
    // Xóa ảnh nếu có
    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }
    
    // Xóa record
    $product->delete();

    return redirect()->route('admin.products.index')
                     ->with('success', 'Đã xóa!');
}
```

---

### **4. MODEL - TƯ���NG TÁC DATABASE**

#### **4.1 Cấu trúc Model cơ bản**

```php
class Product extends Model
{
    // 1. FILLABLE - Cho phép mass assignment
    protected $fillable = [
        'name', 'slug', 'price', 'category_id', 'image', 'stock'
    ];

    // 2. CASTS - Tự động convert kiểu
    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'images' => 'array',
    ];

    // 3. RELATIONSHIPS
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // 4. ACCESSORS - Thuộc tính ảo
    public function getDisplayPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    // 5. MUTATORS - Thay đổi trước khi lưu
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }
}
```

---

#### **4.2 Quan hệ Database**

**belongsTo (n-1):**
```php
// Product thuộc 1 Category
public function category()
{
    return $this->belongsTo(Category::class);
}

// Dùng:
$product->category->name;
```

**hasMany (1-n):**
```php
// Category có nhiều Products
public function products()
{
    return $this->hasMany(Product::class);
}

// Dùng:
$category->products->count();
foreach ($category->products as $product) {
    echo $product->name;
}
```

**belongsToMany (n-n):**
```php
// Product có nhiều Tags, Tag có nhiều Products
public function tags()
{
    return $this->belongsToMany(Tag::class);
}

// Dùng:
$product->tags()->attach($tagId);    // Thêm tag
$product->tags()->detach($tagId);    // Xóa tag
$product->tags()->sync([$id1, $id2]); // Sync tags
```

---

#### **4.3 Query Builder**

```php
// Lấy tất cả
Product::all();

// Lấy theo điều kiện
Product::where('price', '>', 100)->get();

// Lấy 1 record
Product::find(5);                    // Theo ID
Product::where('slug', $slug)->first(); // Theo slug

// findOrFail - 404 nếu không tìm thấy
Product::findOrFail(5);

// Đếm
Product::count();
Product::where('is_active', 1)->count();

// Eager Loading (tránh N+1)
Product::with('category')->get();
Product::with(['category', 'orderItems'])->get();

// Sắp xếp
Product::orderBy('created_at', 'desc')->get();
Product::latest()->get();  // Shortcut
Product::oldest()->get();

// Phân trang
Product::paginate(15);
Product::simplePaginate(15);

// Pluck - Lấy mảng giá trị
Product::pluck('name');  // ['Giày 1', 'Giày 2', ...]
Product::pluck('name', 'id');  // [1 => 'Giày 1', 2 => 'Giày 2']

// Tạo mới
Product::create([
    'name' => 'Giày Nike',
    'price' => 99.99,
]);

// Cập nhật
$product->update(['price' => 89.99]);

// Xóa
$product->delete();
Product::destroy(5);  // Xóa theo ID
Product::destroy([1, 2, 3]);  // Xóa nhiều
```

---

### **5. VIEW - BLADE TEMPLATE**

#### **5.1 Cấu trúc View**

```blade
{{-- Kế thừa layout --}}
@extends('layouts.admin')

{{-- Set title --}}
@section('title', 'Quản lý Sản phẩm')

{{-- Nội dung chính --}}
@section('content')
    <h1>Danh sách Sản phẩm</h1>
    
    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    {{-- Bảng dữ liệu --}}
    <table>
        <thead>
            <tr>
                <th>Tên</th>
                <th>Giá</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->price) }}₫</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}">Sửa</a>
                        
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Không có sản phẩm nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    {{-- Pagination --}}
    {{ $products->links() }}
@endsection

{{-- CSS riêng --}}
@push('styles')
    <style>
        .alert-success { color: green; }
    </style>
@endpush

{{-- JS riêng --}}
@push('scripts')
    <script>
        console.log('Products page loaded');
    </script>
@endpush
```

---

#### **5.2 Blade Directives**

**Cấu trúc:**
```blade
@extends('layouts.admin')          {{-- Kế thừa layout --}}
@section('content') ... @endsection {{-- Định nghĩa section --}}
@yield('content')                   {{-- Hiển thị section --}}

@include('partials.header')         {{-- Include partial view --}}

@push('scripts')                    {{-- Thêm vào stack --}}
@stack('scripts')                   {{-- Hiển thị stack --}}
```

**Hiển thị dữ liệu:**
```blade
{{ $name }}                         {{-- Escape HTML --}}
{!! $html !!}                       {{-- Raw HTML (cẩn thận XSS!) --}}
{{ $name ?? 'Mặc định' }}          {{-- Null coalescing --}}
{{ $product->category->name ?? 'N/A' }}
```

**Điều kiện:**
```blade
@if($product->is_active)
    <span>Đang bán</span>
@elseif($product->stock > 0)
    <span>Còn hàng</span>
@else
    <span>Hết hàng</span>
@endif

@unless($product->is_active)
    <span>Ngừng bán</span>
@endunless

@isset($product->image)
    <img src="{{ Storage::url($product->image) }}">
@endisset

@empty($products)
    <p>Không có sản phẩm</p>
@endempty
```

**Vòng lặp:**
```blade
@foreach($products as $product)
    <li>{{ $product->name }}</li>
@endforeach

@forelse($products as $product)
    <li>{{ $product->name }}</li>
@empty
    <li>Không có sản phẩm</li>
@endforelse

@for($i = 0; $i < 10; $i++)
    <p>{{ $i }}</p>
@endfor

@while($condition)
    ...
@endwhile
```

**Vòng lặp đặc biệt:**
```blade
@foreach($products as $product)
    {{ $loop->index }}      {{-- 0, 1, 2... --}}
    {{ $loop->iteration }}  {{-- 1, 2, 3... --}}
    {{ $loop->first }}      {{-- true nếu là phần tử đầu --}}
    {{ $loop->last }}       {{-- true nếu là phần tử cuối --}}
    {{ $loop->count }}      {{-- Tổng số phần tử --}}
    {{ $loop->remaining }}  {{-- Số phần tử còn lại --}}
    
    @if($loop->first)
        <h3>Danh sách:</h3>
    @endif
@endforeach
```

**Authentication:**
```blade
@auth
    <p>Xin chào {{ auth()->user()->name }}</p>
@endauth

@guest
    <a href="/login">Đăng nhập</a>
@endguest

@if(auth()->check())
    <p>Đã đăng nhập</p>
@endif
```

**CSRF Protection:**
```blade
<form method="POST">
    @csrf  {{-- Bắt buộc cho mọi form POST --}}
    
    @method('PUT')  {{-- Fake HTTP method --}}
    @method('DELETE')
</form>
```

**Validation Errors:**
```blade
@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

@error('name')
    <span class="error">{{ $message }}</span>
@enderror

<input name="name" value="{{ old('name') }}">
{{-- old() giữ giá trị cũ khi validate fail --}}
```

**Helper Functions:**
```blade
{{ asset('images/logo.png') }}
{{-- Output: /images/logo.png --}}

{{ route('admin.products.index') }}
{{-- Output: /admin/products --}}

{{ route('admin.products.edit', $product) }}
{{-- Output: /admin/products/5/edit --}}

{{ url('/about') }}
{{-- Output: http://example.com/about --}}

{{ Storage::url('products/image.jpg') }}
{{-- Output: /storage/products/image.jpg --}}

{{ number_format(12345.67, 2, ',', '.') }}
{{-- Output: 12.345,67 --}}

{{ Str::limit($text, 50) }}
{{-- Cắt text còn 50 ký tự + ... --}}

{{ ucfirst($text) }}
{{-- Viết hoa chữ cái đầu --}}

{{ strtoupper($text) }}
{{-- Viết hoa tất cả --}}

{{ date('d/m/Y', strtotime($product->created_at)) }}
{{-- Format ngày tháng --}}

{{ $product->created_at->format('d/m/Y H:i') }}
{{-- Carbon format --}}

{{ $product->created_at->diffForHumans() }}
{{-- Output: 2 giờ trước --}}
```

---

### **6. UPLOAD FILE & IMAGE**

#### **6.1 Form Upload**

```blade
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <input type="file" name="image" accept="image/*">
    
    @error('image')
        <span class="error">{{ $message }}</span>
    @enderror
    
    <button type="submit">Upload</button>
</form>
```

---

#### **6.2 Controller xử lý**

```php
public function store(Request $request)
{
    // Validate
    $validated = $request->validate([
        'image' => 'required|image|max:2048',
        // image: jpg, jpeg, png, gif, svg, webp
        // max:2048 = 2MB
    ]);

    // Kiểm tra file
    if ($request->hasFile('image')) {
        // Cách 1: Lưu tự động tạo tên
        $path = $request->file('image')->store('products', 'public');
        // Lưu vào: storage/app/public/products/abc123.jpg
        // $path = "products/abc123.jpg"

        // Cách 2: Tự đặt tên
        $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('products', $fileName, 'public');

        // Cách 3: Lấy thông tin file
        $originalName = $request->file('image')->getClientOriginalName();
        $extension = $request->file('image')->getClientOriginalExtension();
        $size = $request->file('image')->getSize();
        $mimeType = $request->file('image')->getMimeType();
    }

    // Lưu path vào database
    Product::create([
        'name' => $request->name,
        'image' => $path,
    ]);
}
```

---

#### **6.3 Hiển thị ảnh**

```blade
@if($product->image)
    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
    {{-- Output: /storage/products/abc123.jpg --}}
@endif
```

**Lưu ý:** Phải chạy `php artisan storage:link` để tạo symbolic link!

---

#### **6.4 Xóa file cũ**

```php
use Illuminate\Support\Facades\Storage;

public function update(Request $request, Product $product)
{
    // Upload ảnh mới
    if ($request->hasFile('image')) {
        // Xóa ảnh cũ
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        // Lưu ảnh mới
        $path = $request->file('image')->store('products', 'public');
        $product->image = $path;
    }
    
    $product->save();
}
```

---

### **7. PAGINATION - PHÂN TRANG**

```php
// Controller
$products = Product::paginate(15);  // 15 items/page

// Hoặc
$products = Product::simplePaginate(15);  // Không có số trang, chỉ Next/Previous
```

```blade
{{-- View --}}
<table>
    @foreach($products as $product)
        <tr>...</tr>
    @endforeach
</table>

{{-- Pagination links --}}
{{ $products->links() }}

{{-- Hoặc dùng Bootstrap --}}
{{ $products->links('pagination::bootstrap-4') }}

{{-- Custom --}}
@if($products->hasPages())
    <nav>
        {{-- Previous --}}
        @if($products->onFirstPage())
            <span>« Previous</span>
        @else
            <a href="{{ $products->previousPageUrl() }}">« Previous</a>
        @endif

        {{-- Page numbers --}}
        @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
            @if($page == $products->currentPage())
                <span>{{ $page }}</span>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next --}}
        @if($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}">Next »</a>
        @else
            <span>Next »</span>
        @endif
    </nav>
@endif

{{-- Thông tin --}}
<p>
    Hiển thị {{ $products->firstItem() }} - {{ $products->lastItem() }}
    trong tổng số {{ $products->total() }} sản phẩm
</p>
```

---

### **8. FLASH MESSAGES**

#### **8.1 Set flash message**

```php
// Controller
return redirect()->route('admin.products.index')
                 ->with('success', 'Đã tạo thành công!');

// Hoặc
session()->flash('success', 'Đã tạo thành công!');
session()->flash('error', 'Có lỗi xảy ra!');
session()->flash('warning', 'Cảnh báo!');
session()->flash('info', 'Thông tin!');
```

---

#### **8.2 Hiển thị trong View**

```blade
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{-- Tất cả messages --}}
@if(session()->has('success') || session()->has('error'))
    <div class="alert alert-{{ session('success') ? 'success' : 'danger' }}">
        {{ session('success') ?? session('error') }}
    </div>
@endif
```

---

### **9. BÀI TẬP THỰC HÀNH**

#### **Bài 1: Trace luồng xem danh sách sản phẩm**

1. Mở browser, vào: `http://127.0.0.1:8000/admin/products`
2. Mở `routes/web.php` → Tìm route `admin/products`
3. Mở `AdminProductController.php` → Đọc method `index()`
4. Mở `resources/views/admin/products/index.blade.php`
5. Debug bằng `dd()`:

```php
public function index()
{
    $products = Product::with('category')->latest()->paginate(15);
    
    // Debug: Xem dữ liệu
    dd($products);
    
    return view('admin.products.index', compact('products'));
}
```

---

#### **Bài 2: Thêm sản phẩm test**

1. Vào: `http://127.0.0.1:8000/admin/products/create`
2. Điền form và submit
3. Xem dữ liệu trong database
4. Trace code xem luồng `create()` → `store()`

---

#### **Bài 3: Hiểu quan hệ**

```php
// Chạy trong tinker: php artisan tinker

$product = Product::first();

// Lấy category
$product->category;
$product->category->name;

// Lấy tất cả products của 1 category
$category = Category::first();
$category->products;
$category->products->count();
```

---

#### **Bài 4: Thêm chức năng mới**

Thêm field "brand" (thương hiệu) cho Product:

1. Tạo migration:
```bash
php artisan make:migration add_brand_to_products_table
```

2. Sửa migration:
```php
public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->string('brand')->nullable()->after('name');
    });
}
```

3. Chạy migration:
```bash
php artisan migrate
```

4. Thêm 'brand' vào `$fillable` trong Model
5. Thêm input brand vào form create/edit
6. Thêm cột brand vào bảng index

---

#### **Bài 5: Tạo module mới**

Tạo quản lý "Suppliers" (Nhà cung cấp):

1. Tạo Model + Migration:
```bash
php artisan make:model Supplier -m
```

2. Định nghĩa migration
3. Tạo Controller:
```bash
php artisan make:controller Admin/SupplierController --resource
```

4. Thêm routes
5. Tạo views: index, create, edit
6. Test CRUD

---

### **10. DEBUG & TROUBLESHOOTING**

#### **10.1 Các lệnh debug**

```php
// Dừng và hiển thị dữ liệu
dd($variable);

// Hiển thị nhưng không dừng
dump($variable);

// Log ra file storage/logs/laravel.log
\Log::info('Debug:', ['product' => $product]);
\Log::error('Error:', ['message' => $e->getMessage()]);

// Xem SQL query
\DB::enableQueryLog();
Product::all();
dd(\DB::getQueryLog());
```

---

#### **10.2 Lỗi thường gặp**

**403 Forbidden:**
- Chưa đăng nhập
- User không phải admin (is_admin = 0)

**419 CSRF Token Mismatch:**
- Thiếu `@csrf` trong form
- Session hết hạn

**404 Not Found:**
- Route không tồn tại
- ID không tìm thấy trong database

**500 Internal Server Error:**
- Lỗi syntax trong code
- Thiếu field trong $fillable
- Quan hệ không đúng

**Validation Error:**
- Dữ liệu không hợp lệ
- Xem `$errors` trong view

---

## 🎓 LỘ TRÌNH HỌC TẬP ĐỀ XUẤT

### **Tuần 1: Cơ bản**
- ✅ Hiểu MVC
- ✅ Routes, Controllers, Views
- ✅ Blade Template cơ bản
- ✅ CRUD Products

### **Tuần 2: Nâng cao**
- ✅ Models & Relationships
- ✅ Validation
- ✅ Upload files
- ✅ Flash messages

### **Tuần 3: Thực hành**
- ✅ Hoàn thiện CRUD tất cả modules
- ✅ Phân quyền admin
- ✅ Tối ưu query (N+1 problem)
- ✅ Pagination

### **Tuần 4: Mở rộng**
- ✅ Tạo module mới
- ✅ Advanced Eloquent
- ✅ API (nếu cần)
- ✅ Testing

---

## 📚 TÀI LIỆU THAM KHẢO

1. **Laravel Documentation**: https://laravel.com/docs
2. **Laracasts**: https://laracasts.com
3. **Laravel Daily**: https://www.youtube.com/@LaravelDaily
4. **Eloquent Relationships**: https://laravel.com/docs/eloquent-relationships

---

## 💡 TIPS HỌC TẬP

1. **Đọc code nhiều hơn viết code** - Hiểu trước, code sau
2. **Debug bằng dd()** - Xem dữ liệu ở mỗi bước
3. **Trace luồng từ Route → View** - Hiểu toàn bộ quy trình
4. **Thực hành CRUD** - Làm đi làm lại cho thuộc
5. **Đọc error messages** - Laravel báo lỗi rất chi tiết
6. **Dùng Tinker** - Test query nhanh: `php artisan tinker`
7. **Xem log** - File `storage/logs/laravel.log`

---

## 🚀 BƯỚC TIẾP THEO

Sau khi nắm vững Admin Panel, bạn có thể học:

1. **API Development** - RESTful API cho mobile app
2. **Real-time Features** - WebSocket, Broadcasting
3. **Queue & Jobs** - Xử lý background tasks
4. **Testing** - PHPUnit, Feature tests
5. **Deployment** - Deploy lên server thật
6. **Performance** - Caching, Optimization
7. **Security** - Best practices, Penetration testing

---

**CHÚC BẠN HỌC TỐT! 🎉**
