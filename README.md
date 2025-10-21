# 👟 SHOE SHOP - LARAVEL E-COMMERCE

Hệ thống website bán giày trực tuyến được xây dựng bằng Laravel Framework.

---

## 📋 MỤC LỤC

1. [Giới thiệu](#-giới-thiệu)
2. [Tính năng](#-tính-năng)
3. [Công nghệ sử dụng](#-công-nghệ-sử-dụng)
4. [Cài đặt](#-cài-đặt)
5. [Cấu trúc dự án](#-cấu-trúc-dự-án)
6. [Hướng dẫn học - Phần ADMIN](#-hướng-dẫn-học---phần-admin)
7. [Hướng dẫn học - Phần USER](#-hướng-dẫn-học---phần-user)
8. [Troubleshooting](#-troubleshooting)

---

## 🎯 GIỚI THIỆU

Website bán giày với đầy đủ chức năng:
- **Frontend**: Khách hàng xem sản phẩm, thêm vào giỏ hàng, đặt hàng
- **Backend Admin**: Quản lý sản phẩm, đơn hàng, người dùng, danh mục

---

## ✨ TÍNH NĂNG

### 👤 **Phần Khách hàng (User)**
- ✅ Xem danh sách sản phẩm
- ✅ Xem chi tiết sản phẩm
- ✅ Thêm vào giỏ hàng (Session-based)
- ✅ Cập nhật/Xóa sản phẩm trong giỏ
- ✅ Đặt hàng (Checkout)
- ✅ Xem lịch sử đơn hàng
- ✅ Đăng ký/Đăng nhập
- ✅ Tìm kiếm sản phẩm

### 🔐 **Phần Quản trị (Admin)**
- ✅ Dashboard thống kê
- ✅ Quản lý sản phẩm (CRUD)
- ✅ Quản lý danh mục (CRUD)
- ✅ Quản lý đơn hàng (Xem, cập nhật trạng thái)
- ✅ Quản lý người dùng (CRUD)
- ✅ Phê duyệt/Từ chối đơn hàng
- ✅ Upload hình ảnh sản phẩm

---

## 🛠️ CÔNG NGHỆ SỬ DỤNG

### **Backend**
- Laravel 11.x
- PHP 8.2+
- MySQL

### **Frontend**
- Blade Template Engine
- Tailwind CSS (Admin)
- Bootstrap 5 (User)
- Alpine.js
- Vanilla JavaScript

### **Khác**
- Composer (PHP Package Manager)
- NPM (Node Package Manager)

---

## 📦 CÀI ĐẶT

### **1. Yêu cầu hệ thống**
```
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM (tùy chọn)
```

### **2. Clone project**
```bash
git clone https://github.com/dangvu2910/webnc.git
cd webnc
```

### **3. Cài đặt dependencies**
```bash
composer install
npm install  # (tùy chọn)
```

### **4. Cấu hình môi trường**
```bash
# Copy file .env
cp .env.example .env

# Tạo application key
php artisan key:generate

# Tạo symbolic link cho storage
php artisan storage:link
```

### **5. Cấu hình database**
Sửa file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webnc
DB_USERNAME=root
DB_PASSWORD=
```

### **6. Chạy migration & seeder**
```bash
# Tạo bảng
php artisan migrate

# Thêm dữ liệu mẫu
php artisan db:seed
```

### **7. Khởi động server**
```bash
php artisan serve
```

Truy cập:
- **Frontend**: http://localhost:8000
- **Admin**: http://localhost:8000/admin (email: admin@example.com, pass: admin123)

---

## 📁 CẤU TRÚC DỰ ÁN

```
webnc/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              # Controllers cho admin
│   │   │   │   ├── ProductController.php
│   │   │   │   ├── OrderController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   └── UserController.php
│   │   │   ├── Auth/               # Authentication
│   │   │   ├── CartController.php  # Giỏ hàng
│   │   │   ├── OrderController.php # Đặt hàng (user)
│   │   │   └── ProductController.php # Sản phẩm (user)
│   │   └── Middleware/
│   │       └── IsAdmin.php         # Middleware kiểm tra admin
│   └── Models/
│       ├── Product.php
│       ├── Order.php
│       ├── OrderItem.php
│       ├── Category.php
│       └── User.php
│
├── database/
│   ├── migrations/                 # Database schema
│   └── seeders/                    # Dữ liệu mẫu
│
├── resources/
│   └── views/
│       ├── admin/                  # Giao diện admin
│       │   ├── products/
│       │   ├── orders/
│       │   ├── categories/
│       │   └── users/
│       ├── user/                   # Giao diện user
│       │   ├── index.blade.php     # Trang chủ
│       │   ├── product.blade.php   # Chi tiết SP
│       │   ├── viewcart.blade.php  # Giỏ hàng
│       │   └── checkout.blade.php  # Thanh toán
│       └── layouts/                # Layouts
│           ├── admin.blade.php
│           └── user.blade.php
│
├── routes/
│   └── web.php                     # Định nghĩa routes
│
├── public/                         # Assets (CSS, JS, images)
│   ├── user/
│   └── vendor/admin/
│
├── storage/                        # Upload files, cache, logs
│   └── app/public/products/        # Hình sản phẩm upload
│
├── ADMIN-GUIDE.md                  # Hướng dẫn học Admin (chi tiết)
├── USER-GUIDE.md                   # Hướng dẫn học User (chi tiết)
└── README.md                       # File này
```

---

## 🎓 HƯỚNG DẪN HỌC - PHẦN ADMIN

### 📚 **1. Tổng quan**

**Mục đích**: Quản lý toàn bộ hệ thống (sản phẩm, đơn hàng, người dùng)

**Middleware bảo mật**: 
- File: `app/Http/Middleware/IsAdmin.php`
- Kiểm tra user có quyền admin không
- Chặn truy cập nếu không phải admin (403)

### 📂 **2. Cấu trúc Controllers**

```
app/Http/Controllers/Admin/
├── ProductController.php     → CRUD sản phẩm
├── CategoryController.php    → CRUD danh mục
├── OrderController.php       → Xem + cập nhật trạng thái đơn hàng
└── UserController.php        → CRUD người dùng
```

**Các method chính** (CRUD):
- `index()` - Hiển thị danh sách
- `create()` - Form thêm mới
- `store()` - Lưu dữ liệu mới
- `edit($id)` - Form sửa
- `update($id)` - Cập nhật
- `destroy($id)` - Xóa

### 🛣️ **3. Routes Admin**

**Prefix**: `/admin/*`  
**Middleware**: `auth`, `is_admin`

Ví dụ routes sản phẩm:
```
GET  /admin/products              → Danh sách
GET  /admin/products/create       → Form thêm
POST /admin/products              → Lưu mới
GET  /admin/products/{id}/edit    → Form sửa
PUT  /admin/products/{id}         → Cập nhật
DELETE /admin/products/{id}       → Xóa
```

### 🗄️ **4. Models & Database**

**Model**: `app/Models/Product.php`

**Quan hệ (Relationships)**:
- Product `belongsTo` Category (1-n)
- Product `hasMany` OrderItem (1-n)
- Order `hasMany` OrderItem (1-n)
- Order `belongsTo` User (1-n)

**Bảng quan trọng**:
- `products` - Sản phẩm
- `categories` - Danh mục
- `orders` - Đơn hàng
- `order_items` - Chi tiết đơn hàng
- `users` - Người dùng

### 🎨 **5. Views Admin**

**Layout**: `resources/views/layouts/admin.blade.php`

**Blade Directives quan trọng**:
- `@extends('layouts.admin')` - Kế thừa layout
- `@section('content')` - Định nghĩa nội dung
- `@csrf` - CSRF token (bắt buộc trong form)
- `@method('PUT')` - Fake HTTP method
- `{{ $var }}` - Hiển thị dữ liệu (escape HTML)
- `@foreach` - Vòng lặp

### 🔄 **6. Luồng xử lý CRUD**

**Thêm sản phẩm**:
```
1. GET /admin/products/create
   → ProductController@create
   → Hiển thị form

2. User điền form và submit

3. POST /admin/products
   → ProductController@store
   → Validate dữ liệu
   → Upload hình (nếu có)
   → Product::create($data)
   → Redirect về danh sách với thông báo
```

**Xem danh sách**:
```
1. GET /admin/products
   → ProductController@index
   → Query database: Product::with('category')->paginate(20)
   → Return view với $products
```

### 🔒 **7. Các khái niệm quan trọng**

**Route Model Binding**:
- Laravel tự động tìm model theo ID trong URL
- Tự động trả về 404 nếu không tìm thấy

**Validation**:
- Kiểm tra dữ liệu đầu vào
- Tự động quay lại form nếu lỗi

**File Upload**:
- Upload vào `storage/app/public/`
- Cần chạy `php artisan storage:link`

**Flash Session**:
- Lưu thông báo tạm thời (1 request)
- Hiển thị: `@if(session('success')) ... @endif`

### 📖 **8. Tài liệu chi tiết**

👉 **Xem file `ADMIN-GUIDE.md`** để có:
- Code mẫu đầy đủ
- Giải thích chi tiết từng dòng
- Ví dụ thực tế
- Bài tập thực hành

---

## 👥 HƯỚNG DẪN HỌC - PHẦN USER

### 📚 **1. Tổng quan**

**Mục đích**: Khách hàng mua sắm trực tuyến

**Đặc điểm**:
- Không cần middleware bảo mật (public)
- Sử dụng Session để lưu giỏ hàng
- Giao diện thân thiện, dễ sử dụng

### 📂 **2. Cấu trúc Controllers**

```
app/Http/Controllers/
├── ProductController.php    → Xem sản phẩm
├── CartController.php       → Quản lý giỏ hàng
├── OrderController.php      → Đặt hàng
└── Auth/
    ├── RegisteredUserController.php     → Đăng ký
    └── AuthenticatedSessionController.php → Đăng nhập
```

**Các method chính**:
- `ProductController@index` - Trang chủ
- `ProductController@show` - Chi tiết sản phẩm
- `CartController@add` - Thêm vào giỏ
- `CartController@update` - Cập nhật số lượng
- `OrderController@store` - Tạo đơn hàng

### 🛣️ **3. Routes User**

**Prefix**: Không có (root level)

Ví dụ routes:
```
GET  /                     → Trang chủ
GET  /product/{id}         → Chi tiết sản phẩm
GET  /cart                 → Giỏ hàng
POST /cart/add             → Thêm vào giỏ
GET  /checkout             → Thanh toán
POST /checkout             → Xử lý đặt hàng
GET  /account              → Tài khoản (cần đăng nhập)
```

### 🛒 **4. Session & Giỏ hàng**

**Cấu trúc giỏ hàng trong session**:
```
session['cart'] = [
    '5' => [
        'id' => '5',
        'name' => 'Giày Nike',
        'price' => 99.00,
        'qty' => 2,
        'image' => 'products/nike.jpg'
    ],
    ...
]
```

**Các thao tác**:
- `session(['cart' => $cart])` - Lưu
- `session('cart', [])` - Lấy
- `session()->forget('cart')` - Xóa

**Tính toán**:
- Tổng số lượng: `array_sum(array_column($cart, 'qty'))`
- Tổng tiền: Foreach cộng dồn

### 🔐 **5. Authentication**

**Đăng nhập**:
```
POST /login
→ Validate email + password
→ Auth::attempt($credentials)
→ Redirect về trang trước hoặc trang chủ
```

**Đăng xuất**:
```
POST /logout
→ Auth::logout()
→ Xóa session
→ Redirect về trang chủ
```

**Kiểm tra đã đăng nhập**:
- `Auth::check()` - true/false
- `Auth::user()` - Lấy thông tin user
- `@auth` / `@guest` trong Blade

### 🛍️ **6. Luồng mua hàng**

```
1. Xem sản phẩm
   GET /product/{id}
   ↓
2. Thêm vào giỏ
   POST /cart/add
   → Lưu vào session['cart']
   ↓
3. Xem giỏ hàng
   GET /cart
   → Hiển thị từ session
   ↓
4. Thanh toán
   GET /checkout
   → Nhập thông tin: tên, địa chỉ, SĐT
   ↓
5. Đặt hàng
   POST /checkout
   → Tạo Order + OrderItems
   → Xóa session['cart']
   → Hiển thị thông báo thành công
```

### 🎨 **7. Views User**

**Layout**: `resources/views/layouts/user.blade.php`

**Trang quan trọng**:
- `user/index.blade.php` - Trang chủ
- `user/product.blade.php` - Chi tiết sản phẩm
- `user/viewcart.blade.php` - Giỏ hàng
- `user/checkout.blade.php` - Thanh toán
- `user/account.blade.php` - Tài khoản

### 🔒 **8. Bảo mật**

**CSRF Protection**:
- Bắt buộc có `@csrf` trong mọi form POST
- Tự động kiểm tra token

**XSS Protection**:
- `{{ $var }}` tự động escape HTML
- `{!! $html !!}` không escape (cẩn thận!)

**Validation**:
- Luôn validate input trước khi xử lý

### 📖 **9. Tài liệu chi tiết**

👉 **Xem file `USER-GUIDE.md`** để có:
- Code mẫu đầy đủ
- Giải thích chi tiết AJAX, JavaScript
- Ví dụ về Blade Directives
- Helper functions hữu ích
- Bài tập thực hành

---

## ❓ TROUBLESHOOTING

### ⚠️ **Lỗi 403 khi vào /admin**
```
Nguyên nhân: User không phải admin hoặc chưa đăng nhập
Giải pháp:
- Kiểm tra cột is_admin trong bảng users = 1
- Đăng nhập với tài khoản admin
```

### ⚠️ **Lỗi 419 - CSRF Token Mismatch**
```
Nguyên nhân: Thiếu @csrf trong form hoặc session hết hạn
Giải pháp:
- Thêm @csrf trong mọi form POST
- Tăng SESSION_LIFETIME trong .env
- Clear cache: php artisan cache:clear
```

### ⚠️ **Hình ảnh không hiển thị**
```
Nguyên nhân: Chưa tạo symbolic link
Giải pháp:
php artisan storage:link
```

### ⚠️ **Lỗi upload file**
```
Nguyên nhân: Quyền thư mục storage/
Giải pháp:
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### ⚠️ **Session không lưu giỏ hàng**
```
Giải pháp:
php artisan config:clear
php artisan cache:clear
Kiểm tra SESSION_DRIVER trong .env (file hoặc database)
```

---

## 📚 HỌC THÊM

### **Laravel Official**
- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Bootcamp](https://bootcamp.laravel.com)
- [Laracasts Video Tutorials](https://laracasts.com)

### **Các khái niệm cần nắm**
1. **MVC Pattern** - Model View Controller
2. **Eloquent ORM** - Database queries
3. **Blade Template** - View engine
4. **Middleware** - Request filtering
5. **Validation** - Input checking
6. **File Storage** - Upload management
7. **Session** - State management
8. **Authentication** - User login

### **Files quan trọng cần đọc**
```
✅ routes/web.php              - Tất cả routes
✅ app/Http/Controllers/       - Logic xử lý
✅ app/Models/                 - Database models
✅ resources/views/            - Giao diện
✅ database/migrations/        - Database schema
✅ ADMIN-GUIDE.md             - Hướng dẫn Admin chi tiết
✅ USER-GUIDE.md              - Hướng dẫn User chi tiết
```

---

## 🚀 CÁCH HỌC HIỆU QUẢ

### **1. Đọc tổng quan**
- Đọc README.md này (file hiện tại)
- Hiểu tổng quan về cấu trúc

### **2. Học từng phần**
- **Admin**: Đọc `ADMIN-GUIDE.md`
- **User**: Đọc `USER-GUIDE.md`

### **3. Trace code thực tế**
```
Ví dụ: Thêm sản phẩm vào giỏ
1. Mở routes/web.php → Tìm POST /cart/add
2. Mở CartController@add → Hiểu logic
3. Mở view có form add to cart
4. Test chức năng trên trình duyệt
5. Debug bằng dd() hoặc dump()
```

### **4. Thực hành**
- Sửa code có sẵn
- Thêm chức năng mới (VD: Wishlist, Reviews)
- Tạo module mới (VD: Coupons, Discounts)

### **5. Debug khi gặp lỗi**
```php
// Xem dữ liệu và dừng
dd($variable);

// Xem dữ liệu nhưng không dừng  
dump($variable);

// Log ra file
\Log::info('Debug:', ['data' => $variable]);
```

---

## 📞 HỖ TRỢ

Nếu gặp vấn đề:
1. Đọc phần Troubleshooting ở trên
2. Xem log tại `storage/logs/laravel.log`
3. Tìm kiếm trên Google với từ khóa: "Laravel [lỗi của bạn]"
4. Hỏi trên Laravel Forum hoặc Stack Overflow

---

## 📄 LICENSE

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
