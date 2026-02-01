# Test Cases - Tìm Kiếm & Lọc Sản Phẩm

## TC_SEARCH_01: Xem danh sách sản phẩm
| Trường | Giá trị |
|--------|--------|
| **Mục tiêu** | Xem danh sách sản phẩm trên trang chủ |
| **Các bước** | 1. Mở trang `/` (trang chủ)<br>2. Cuộn xuống phần sản phẩm |
| **Dữ liệu** | N/A |
| **Kết quả mong đợi** | Hiển thị danh sách giày đẹp, có hình ảnh, giá, thương hiệu |
| **Trạng thái** | ✅ Pass |

---

## TC_SEARCH_02: Tìm theo tên giày
| Trường | Giá trị |
|--------|--------|
| **Mục tiêu** | Tìm kiếm sản phẩm theo tên |
| **Các bước** | 1. Nhấp biểu tượng 🔍 ở header<br>2. Nhập từ khóa "Nike Air Force"<br>3. Nhấn "Tìm kiếm" |
| **Dữ liệu** | "Nike Air Force" |
| **Kết quả mong đợi** | Hiển thị sản phẩm có tên chứa "Nike" hoặc "Air Force" |
| **Trạng thái** | ✅ Pass |

---

## TC_SEARCH_03: Lọc theo danh mục/loại
| Trường | Giá trị |
|--------|--------|
| **Mục tiêu** | Lọc sản phẩm theo danh mục |
| **Các bước** | 1. Nhấp 🔍 ở header<br>2. Chọn danh mục "Sneaker"<br>3. Nhấn "Tìm kiếm" |
| **Dữ liệu** | Danh mục = "Sneaker" |
| **Kết quả mong đợi** | Chỉ hiển thị sản phẩm loại Sneaker |
| **Trạng thái** | ⏳ Chưa hoàn thành |

---

## TC_SEARCH_04: Tìm theo thương hiệu
| Trường | Giá trị |
|--------|--------|
| **Mục tiêu** | Tìm sản phẩm theo thương hiệu |
| **Các bước** | 1. Nhấp 🔍<br>2. Nhập "Nike"<br>3. Nhấn "Tìm kiếm" |
| **Dữ liệu** | "Nike" |
| **Kết quả mong đợi** | Hiển thị tất cả sản phẩm Nike |
| **Trạng thái** | ✅ Pass |

---

## TC_SEARCH_05: Tìm theo chất liệu
| Trường | Giá trị |
|--------|--------|
| **Mục tiêu** | Tìm sản phẩm theo chất liệu |
| **Các bước** | 1. Nhấp 🔍<br>2. Nhập "Da thật"<br>3. Nhấn "Tìm kiếm" |
| **Dữ liệu** | "Da thật" |
| **Kết quả mong đợi** | Hiển thị sản phẩm chất liệu Da thật |
| **Trạng thái** | ✅ Pass |

---

## TC_SEARCH_06: Tìm kiếm trả về 0 kết quả
| Trường | Giá trị |
|--------|--------|
| **Mục tiêu** | Kiểm thử khi không tìm thấy kết quả |
| **Các bước** | 1. Nhấp 🔍<br>2. Nhập "xyzabc123"<br>3. Nhấn "Tìm kiếm" |
| **Dữ liệu** | "xyzabc123" |
| **Kết quả mong đợi** | Hiển thị "Không tìm thấy sản phẩm nào" |
| **Trạng thái** | ✅ Pass |

---

## TC_SEARCH_07: Tìm kiếm rỗng
| Trường | Giá trị |
|--------|--------|
| **Mục tiêu** | Kiểm thử khi tìm kiếm trống |
| **Các bước** | 1. Nhấp 🔍<br>2. Để trống ô tìm kiếm<br>3. Nhấn "Tìm kiếm" |
| **Dữ liệu** | "" (rỗng) |
| **Kết quả mong đợi** | Hiển thị "Vui lòng nhập từ khóa" |
| **Trạng thái** | ✅ Pass |

---

## TC_SEARCH_08: Phân trang kết quả tìm kiếm
| Trường | Giá trị |
|--------|--------|
| **Mục tiêu** | Kiểm thử phân trang kết quả |
| **Các bước** | 1. Tìm từ khóa có >12 kết quả<br>2. Xem trang 1<br>3. Nhấn "Trang 2" |
| **Dữ liệu** | Từ khóa: "giày" |
| **Kết quả mong đợi** | Hiển thị 12 sản phẩm/trang, có nút phân trang |
| **Trạng thái** | ✅ Pass |

---

## TC_SEARCH_09: Xem chi tiết sản phẩm từ kết quả
| Trường | Giá trị |
|--------|--------|
| **Mục tiêu** | Nhấp vào sản phẩm từ kết quả tìm kiếm |
| **Các bước** | 1. Tìm "Nike"<br>2. Nhấp nút "Xem chi tiết"<br>3. Kiểm tra trang chi tiết |
| **Dữ liệu** | "Nike" |
| **Kết quả mong đợi** | Mở trang chi tiết sản phẩm với đầy đủ thông tin |
| **Trạng thái** | ✅ Pass |

---

## TC_SEARCH_10: Kết quả hiển thị đủ thông tin
| Trường | Giá trị |
|--------|--------|
| **Mục tiêu** | Kiểm thử thông tin trên thẻ sản phẩm |
| **Các bước** | 1. Tìm "Nike"<br>2. Kiểm tra mỗi thẻ sản phẩm |
| **Dữ liệu** | "Nike" |
| **Kết quả mong đợi** | Mỗi sản phẩm có: Ảnh, Tên, Thương hiệu, Chất liệu, Rating ⭐, Giá, "Xem chi tiết" |
| **Trạng thái** | ✅ Pass |

---

## TC_SEARCH_11: Lọc theo khoảng giá (Tương lai)
| Trường | Giá trị |
|--------|--------|
| **Mục tiêu** | Lọc sản phẩm theo giá (min-max) |
| **Các bước** | 1. Nhấp 🔍<br>2. Chọn giá từ 1,000,000 - 3,000,000<br>3. Nhấn "Tìm kiếm" |
| **Dữ liệu** | min_price: 1000000, max_price: 3000000 |
| **Kết quả mong đợi** | Hiển thị sản phẩm trong khoảng giá |
| **Trạng thái** | ⏳ Chưa hoàn thành |

---

## TC_SEARCH_12: Tìm kiếm phân biệt hoa/thường
| Trường | Giá trị |
|--------|--------|
| **Mục tiêu** | Tìm kiếm không phân biệt hoa/thường |
| **Các bước** | 1. Tìm "NIKE"<br>2. Tìm "Nike"<br>3. So sánh kết quả |
| **Dữ liệu** | "NIKE" vs "Nike" |
| **Kết quả mong đợi** | Cả hai trả về kết quả giống nhau |
| **Trạng thái** | ✅ Pass |
