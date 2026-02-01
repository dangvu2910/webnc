# Hướng Dẫn Tính Năng Tìm Kiếm và Quản Lý Sản Phẩm

## 📌 Tính Năng Mới

### 1. **Tìm Kiếm Sản Phẩm Nâng Cao**
- Biểu tượng 🔍 (magnifying glass) ở header cho phép tìm kiếm
- Tìm kiếm theo: **Tên sản phẩm**, **Mô tả**, **SKU**, **Thương hiệu**, **Chất liệu**
- Kết quả sắp xếp theo: Sản phẩm nổi bật → Doanh số bán → Đánh giá → Tên sản phẩm
- Hiển thị pagination (12 sản phẩm/trang)

### 2. **Thông Tin Sản Phẩm Chi Tiết**

Mỗi sản phẩm giờ đây có thể lưu:

| Thông tin | Mô tả | Vị trí hiển thị |
|-----------|-------|-----------------|
| **Thương hiệu** (Brand) | VD: Nike, Adidas, Puma | Badge trên thẻ sản phẩm + trang chi tiết |
| **Chất liệu** (Material) | VD: Da thật, Vải canvas | Badge trên thẻ sản phẩm + trang chi tiết |
| **Thông số kỹ thuật** (Specifications) | VD: Trọng lượng, Kích thước | Mục riêng trên trang chi tiết |
| **Đánh giá** (Rating) | 0-5 sao | Hiển thị ⭐ trên thẻ sản phẩm |
| **Số lượng đánh giá** (Reviews Count) | Tự động tính | Hiển thị bên cạnh rating |
| **Lượt xem** (Views Count) | Tự động cập nhật | Không hiển thị (dành cho thống kê) |
| **Số lượng bán** (Sales Count) | Tự động cập nhật | Dùng cho sắp xếp kết quả tìm kiếm |
| **Bảo hành** (Warranty) | VD: Bảo hành 1 năm | Mục riêng trên trang chi tiết |
| **Hướng dẫn bảo quản** (Care Instructions) | VD: Vệ sinh bằng nước ấm | Mục riêng trên trang chi tiết |

## 🔧 Cách Sử Dụng

### **Tìm Kiếm Sản Phẩm (Frontend - Khách hàng)**

1. Nhấp vào biểu tượng 🔍 ở phía trên bên phải header
2. Nhập từ khóa tìm kiếm (tên sản phẩm, thương hiệu, v.v.)
3. Nhấp **"Tìm"** hoặc bấm Enter
4. Xem kết quả:
   - Hiển thị số lượng sản phẩm tìm thấy
   - Mỗi sản phẩm hiển thị: Ảnh, Tên, Thương hiệu, Chất liệu, Rating, Giá
   - Phân trang tự động cho nhiều hơn 12 sản phẩm

### **Thêm/Chỉnh Sửa Thông Tin Sản Phẩm (Admin)**

1. **Truy cập Admin Panel** → **Quản Lý Sản Phẩm**
2. **Thêm Sản Phẩm Mới** hoặc **Chỉnh Sửa Sản Phẩm Hiện Có**

#### Các Trường Có Sẵn:
- Tên sản phẩm *
- Danh mục *
- Mô tả
- Giá gốc * (VNĐ)
- Giá khuyến mãi (VNĐ)
- Số lượng tồn kho *
- Size (VD: 36,37,38,39,40)
- Màu sắc (VD: Đen, Trắng, Xanh)

#### **Phần "Thông Tin Bổ Sung":**
- ✏️ **Thương hiệu** - VD: Nike, Adidas
- ✏️ **Chất liệu** - VD: Da thật, Vải canvas
- 📝 **Thông số kỹ thuật** - VD: Trọng lượng, Kích thước
- ⭐ **Đánh giá** - Nhập số từ 0-5 (VD: 4.5)
- 📋 **Bảo hành** - VD: Bảo hành 1 năm toàn bộ sản phẩm
- 🛡️ **Hướng dẫn bảo quản** - VD: Vệ sinh bằng nước ấm

3. Nhấp **"Thêm sản phẩm"** hoặc **"Cập nhật sản phẩm"**

## 📊 Hiển Thị Trên Trang Sản Phẩm

### Kết Quả Tìm Kiếm:
```
[Ảnh]
Tên sản phẩm
🏷️ Nike 🏷️ Da thật
⭐⭐⭐⭐☆ (24 đánh giá)
✓ Còn hàng (15)
Giá: 2,990,000 VNĐ
[Xem chi tiết]
```

### Trang Chi Tiết Sản Phẩm:
```
[Ảnh lớn]
Tên sản phẩm
🏷️ Nike 🏷️ Da thật

⭐⭐⭐⭐☆ (24 đánh giá)
✓ Còn hàng (15 sản phẩm)

Giá: 2,990,000 VNĐ

Mô tả: ...

📋 Thông số kỹ thuật
Trọng lượng: 250g, Kích thước: 35cm

🔒 Bảo hành
Bảo hành 1 năm toàn bộ sản phẩm

🛡️ Hướng dẫn bảo quản
Vệ sinh sạch sẽ bằng nước ấm...

[Số lượng: 1] [Thêm vào giỏ]
```

## 🗄️ Cơ Sở Dữ Liệu

### Các Cột Mới Được Thêm:
```sql
brand VARCHAR(255)                  -- Thương hiệu
material VARCHAR(255)               -- Chất liệu
specifications TEXT                 -- Thông số kỹ thuật
rating DECIMAL(3,2) DEFAULT 0       -- Đánh giá (0-5)
reviews_count INT DEFAULT 0         -- Số lượng đánh giá
views_count INT DEFAULT 0           -- Số lượt xem
sales_count INT DEFAULT 0           -- Số lượng bán
warranty TEXT                       -- Bảo hành
care_instructions TEXT              -- Hướng dẫn bảo quản
```

## 🎯 API Tìm Kiếm

**Route:** `GET /search?q={keyword}`

**Ví dụ:**
- `/search?q=nike` - Tìm tất cả sản phẩm có "nike"
- `/search?q=da` - Tìm sản phẩm có chứa "da"

**Trả về:** Trang kết quả tìm kiếm với phân trang

## 💡 Mẹo Sử Dụng

✅ **Để tìm kiếm tốt hơn:**
- Gõ từ khóa chính xác
- Tìm kiếm theo thương hiệu (VD: Nike, Adidas)
- Tìm kiếm theo chất liệu (VD: Da, Canvas)
- Tìm kiếm theo tên sản phẩm cụ thể

✅ **Để quản lý sản phẩm tốt hơn:**
- Luôn nhập thương hiệu để dễ tìm kiếm
- Cập nhật đánh giá từ khách hàng
- Mô tả kỹ thông số kỹ thuật
- Hướng dẫn rõ ràng cách bảo quản

## 🔄 Tự Động Cập Nhật

- **sales_count**: Tự động tăng khi có đơn hàng (cần cập nhật thêm)
- **views_count**: Tự động tăng mỗi lần khách hàng xem (cần cập nhật thêm)
- **reviews_count**: Có thể cập nhật bằng tay hoặc tự động từ hệ thống bình luận

## 📝 Ghi Chú

- Migration đã được chạy thành công
- Tất cả các trường bổ sung là tuỳ chọn (nullable)
- Không ảnh hưởng đến các sản phẩm hiện có
