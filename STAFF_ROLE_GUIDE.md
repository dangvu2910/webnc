# Hướng dẫn Sử dụng Role Nhân viên (Staff)

## Tổng quan
Bạn đã thêm một role nhân viên (staff) hoàn chỉnh với các chức năng:
- Quản lý đơn hàng (xem danh sách, xem chi tiết, cập nhật trạng thái, xác nhận/hủy)
- Quản lý hỗ trợ khách hàng (xem yêu cầu, phản hồi, cập nhật trạng thái và độ ưu tiên)

## Cấu trúc Cơ sở Dữ liệu

### Thay đổi Users Table
Cột `is_admin` giữ nguyên để tương thích. Thêm cột `role`:
- `role` (enum): `customer`, `staff`, `admin`

## Tài khoản Mẫu

### Admin
- Email: `admin@example.com`
- Password: `admin`
- Role: `admin`

### Staff (Nhân viên)
- Email: `staff@example.com`
- Password: `staff123`
- Role: `staff`

## Routes/URLs

### Cho Nhân viên
- `/staff` hoặc `/staff/dashboard` - Dashboard nhân viên
- `/staff/orders` - Danh sách đơn hàng
- `/staff/orders/{order}` - Chi tiết đơn hàng
- `/staff/support` - Danh sách yêu cầu hỗ trợ
- `/staff/support/{ticket}` - Chi tiết yêu cầu hỗ trợ

## Các Tính Năng

### Dashboard Nhân viên
Hiển thị:
- Tổng số đơn hàng
- Số đơn hàng hôm nay
- Tổng số yêu cầu hỗ trợ
- Số yêu cầu hôm nay
- Danh sách 10 đơn hàng chờ xử lý
- Danh sách 10 yêu cầu hỗ trợ chờ xử lý

### Quản lý Đơn Hàng
Nhân viên có thể:
- Xem danh sách tất cả đơn hàng
- Lọc theo trạng thái (pending, confirmed, shipped, delivered, cancelled)
- Xem chi tiết đơn hàng
- Cập nhật trạng thái đơn hàng
- Xác nhận đơn hàng (pending → confirmed)
- Hủy đơn hàng (pending → cancelled)

### Quản lý Hỗ trợ Khách hàng
Nhân viên có thể:
- Xem danh sách tất cả yêu cầu hỗ trợ
- Lọc theo trạng thái (open, in_progress, resolved, closed)
- Lọc theo độ ưu tiên (low, medium, high, urgent)
- Xem chi tiết yêu cầu
- Thêm phản hồi (là admin response)
- Cập nhật trạng thái yêu cầu
- Cập nhật độ ưu tiên yêu cầu

## Files Tạo Ra

### Controllers
- `app/Http/Controllers/Staff/DashboardController.php`
- `app/Http/Controllers/Staff/OrderController.php`
- `app/Http/Controllers/Staff/SupportController.php`

### Middleware
- `app/Http/Middleware/IsStaff.php` - Kiểm tra user có role staff hoặc admin

### Migrations
- `database/migrations/2026_01_28_000001_add_role_to_users_table.php`

### Seeders
- `database/seeders/StaffUserSeeder.php`

### Views
- `resources/views/staff/dashboard.blade.php`
- `resources/views/staff/orders/index.blade.php`
- `resources/views/staff/orders/show.blade.php`
- `resources/views/staff/support/index.blade.php`
- `resources/views/staff/support/show.blade.php`

## Bảo mật

- Nhân viên chỉ có thể truy cập `/staff` routes (không thể truy cập admin features)
- Không thể quản lý sản phẩm, danh mục, người dùng
- Chỉ có thể xử lý đơn hàng và hỗ trợ khách hàng
- Middleware `is_staff` kiểm tra role staff hoặc admin

## Cách Tạo Tài Khoản Nhân viên Mới

1. Vào admin dashboard
2. Vào mục "Quản lý người dùng"
3. Tạo người dùng mới
4. Set role = `staff`

Hoặc qua database trực tiếp:
```sql
INSERT INTO users (name, username, email, password, role, created_at, updated_at) 
VALUES ('Nhân viên Mới', 'staff2', 'staff2@example.com', password_hash, 'staff', now(), now());
```

## Cập nhật Admin Hiện tại (Tùy chọn)

Nếu bạn muốn cập nhật user hiện tại từ admin sang staff:
```sql
UPDATE users SET role = 'staff' WHERE email = 'email@example.com';
```

## Ghi Chú

- Nhân viên có thể đăng nhập bằng email hoặc username
- Sau khi đăng nhập, nhân viên sẽ được tự động redirect đến `/staff/dashboard`
- Nhân viên có thể đăng xuất như bình thường
- Dashboard nhân viên hiển thị thông tin tóm tắt và danh sách công việc cấp bách
