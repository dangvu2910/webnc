# 📁 Danh Sách File Hỗ Trợ Khách Hàng Được Tạo

## 📊 Tóm Tắt
- **Models:** 2 files
- **Controllers:** 2 files  
- **Migrations:** 2 files
- **Views:** 5 files
- **Documentation:** 3 files
- **Routes:** Thêm 11 routes vào `web.php`

---

## 🗂️ Chi Tiết Cấu Trúc

### 📦 Models (app/Models/)
```
app/Models/
├── SupportTicket.php         (Model cho yêu cầu hỗ trợ)
└── SupportResponse.php        (Model cho phản hồi)
```

**SupportTicket.php:**
- Thuộc tính: id, user_id, subject, description, status, priority, category, timestamps
- Quan hệ: belongsTo User, hasMany SupportResponse

**SupportResponse.php:**
- Thuộc tính: id, support_ticket_id, user_id, response_text, is_admin_response, timestamps
- Quan hệ: belongsTo SupportTicket, belongsTo User

---

### 🎮 Controllers (app/Http/Controllers/)
```
app/Http/Controllers/
├── SupportController.php          (Khách hàng)
└── Admin/
    └── SupportController.php      (Admin)
```

**SupportController.php (Khách hàng):**
- `index()` - Danh sách yêu cầu của khách hàng
- `create()` - Form tạo yêu cầu
- `store()` - Lưu yêu cầu mới
- `show()` - Xem chi tiết + chat
- `addResponse()` - Thêm phản hồi
- `close()` - Đóng yêu cầu

**Admin/SupportController.php:**
- `index()` - Danh sách tất cả yêu cầu + filter
- `show()` - Xem chi tiết yêu cầu
- `updateStatus()` - Cập nhật trạng thái
- `updatePriority()` - Cập nhật độ ưu tiên
- `destroy()` - Xóa yêu cầu

---

### 🗄️ Migrations (database/migrations/)
```
database/migrations/
├── 2026_01_28_000001_create_support_tickets_table.php
└── 2026_01_28_000002_create_support_responses_table.php
```

**Create Support Tickets Table:**
```sql
- id (primary)
- user_id (foreign → users)
- subject (string, 255)
- description (longText)
- status (enum: open, in_progress, resolved, closed)
- priority (enum: low, medium, high, urgent)
- category (string, nullable)
- created_at, updated_at
- Indexes: user_id, status, priority
```

**Create Support Responses Table:**
```sql
- id (primary)
- support_ticket_id (foreign → support_tickets)
- user_id (foreign → users)
- response_text (longText)
- is_admin_response (boolean)
- created_at, updated_at
- Indexes: support_ticket_id, user_id
```

---

### 🎨 Views (resources/views/)
```
resources/views/
├── user/support/
│   ├── index.blade.php        (Danh sách yêu cầu - card style)
│   ├── create.blade.php       (Form tạo yêu cầu)
│   └── show.blade.php         (Chat interface - modern)
└── admin/support/
    ├── index.blade.php        (Danh sách admin - table)
    └── show.blade.php         (Admin chat + management)
```

**user/support/index.blade.php:**
- Hiển thị card yêu cầu
- Nút "Tạo yêu cầu mới"
- Hover effect
- Responsive grid layout

**user/support/create.blade.php:**
- Form: Danh mục, Tiêu đề, Mô tả, Độ ưu tiên
- Validation errors
- Mẹo tạo yêu cầu
- Buttons: Quay lại, Đặt lại, Gửi

**user/support/show.blade.php:**
- Modern chat interface
- Sidebar thông tin chi tiết
- Messages area (auto-scroll)
- Input area for responses
- Auto-refresh (5 giây)
- Close button
- Responsive design

**admin/support/index.blade.php:**
- Table danh sách yêu cầu
- Tìm kiếm (tiêu đề, mô tả, email)
- Lọc theo trạng thái
- Lọc theo độ ưu tiên
- Pagination (15 items/page)
- "Xem chi tiết" button

**admin/support/show.blade.php:**
- Thông tin khách hàng
- Full conversation view
- Admin response form
- Status update form
- Priority update form
- Delete button
- Sidebar controls

---

### 📄 Routes (routes/web.php)
```
Khách hàng (protected by auth):
  GET    /support                      → support.index
  GET    /support/create               → support.create
  POST   /support                      → support.store
  GET    /support/{ticket}             → support.show
  POST   /support/{ticket}/response    → support.addResponse
  POST   /support/{ticket}/close       → support.close

Admin (protected by auth + is_admin):
  GET    /admin/support                → admin.support.index
  GET    /admin/support/{ticket}       → admin.support.show
  POST   /admin/support/{ticket}/status   → admin.support.updateStatus
  POST   /admin/support/{ticket}/priority → admin.support.updatePriority
  DELETE /admin/support/{ticket}       → admin.support.destroy
```

---

### 📚 Documentation
```
/
├── SUPPORT_FEATURE_GUIDE.md       (Hướng dẫn tổng quan chức năng)
├── CUSTOMER_CHAT_GUIDE.md         (Hướng dẫn chi tiết sử dụng)
└── FEATURES_CHECKLIST.md          (Danh sách tính năng hoàn thành)
```

---

### 🔧 Modified Files
```
resources/views/
├── partials/header.blade.php      (Thêm icon support)
└── user/account.blade.php         (Thêm nút support)

routes/
└── web.php                         (Thêm routes + imports)
```

---

## 📋 Tính Năng Chi Tiết

### Khách Hàng
- ✅ Tạo yêu cầu hỗ trợ với danh mục, tiêu đề, mô tả, độ ưu tiên
- ✅ Xem danh sách tất cả yêu cầu của họ
- ✅ Chat trực tiếp với admin (real-time)
- ✅ Auto-scroll tin nhắn
- ✅ Auto-refresh mỗi 5 giây
- ✅ Đóng yêu cầu
- ✅ Responsive design

### Admin
- ✅ Xem tất cả yêu cầu hỗ trợ
- ✅ Tìm kiếm theo: tiêu đề, mô tả, email khách hàng
- ✅ Lọc theo trạng thái (4 loại)
- ✅ Lọc theo độ ưu tiên (4 mức)
- ✅ Phản hồi yêu cầu từ admin
- ✅ Cập nhật trạng thái
- ✅ Cập nhật độ ưu tiên
- ✅ Xóa yêu cầu
- ✅ Pagination

---

## 🎯 Cách Sử Dụng

### Khác Hàng
1. Click icon hỗ trợ ở header (khi đã login)
2. Chọn "Tạo yêu cầu mới"
3. Điền form → Gửi
4. Xem danh sách yêu cầu
5. Click vào yêu cầu → Chat với admin

### Admin
1. Login admin
2. Truy cập `/admin/support`
3. Dùng tìm kiếm/lọc để tìm yêu cầu
4. Click "Xem chi tiết"
5. Phản hồi, cập nhật trạng thái, cập nhật độ ưu tiên

---

## 🔐 Bảo Mật

- Khách hàng chỉ xem yêu cầu của họ
- Middleware `auth` bảo vệ tất cả routes
- Middleware `is_admin` bảo vệ admin routes
- Policy check trong controller

---

## 🎨 Giao Diện

### Khách Hàng
- **Index:** Card layout, responsive grid
- **Create:** Form với validation feedback
- **Show:** Modern chat interface (sidebar + messages)

### Admin
- **Index:** Table style, filters, pagination
- **Show:** Split view (messages + controls)

---

## 📦 Database

**Tables Created:**
- `support_tickets` (status, priority, timestamps)
- `support_responses` (is_admin_response flag)

**Indexes:**
- support_tickets: user_id, status, priority
- support_responses: support_ticket_id, user_id

---

## 🚀 Installation

```bash
# 1. Files đã được tạo
# 2. Models: app/Models/
# 3. Controllers: app/Http/Controllers/
# 4. Views: resources/views/
# 5. Migrations: database/migrations/

# 6. Run migrations
php artisan migrate

# 7. Truy cập
# Khách hàng: /support
# Admin: /admin/support
```

---

## 🆚 So Sánh Trước/Sau

| Tính Năng | Trước | Sau |
|----------|-------|-----|
| Hỗ trợ khách hàng | ❌ Không | ✅ Có |
| Chat real-time | ❌ Không | ✅ Có |
| Danh sách yêu cầu | ❌ Không | ✅ Có |
| Quản lý trạng thái | ❌ Không | ✅ Có |
| Tìm kiếm/Lọc | ❌ Không | ✅ Có |
| Auto-refresh | ❌ Không | ✅ Có |

---

**Phiên bản:** 1.0  
**Ngày:** 28/01/2026  
**Status:** ✅ Hoàn Thành & Sẵn Sàng Sử Dụng
