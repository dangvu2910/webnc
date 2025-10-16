<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $examples = [
            ['sku' => 'p1', 'name' => 'Giày chạy bộ nam', 'price' => 99, 'image' => 'user/images/card-item1.jpg', 'description' => 'Giày chạy bộ êm ái, phù hợp cho chạy bộ và đi hàng ngày.'],
            ['sku' => 'p2', 'name' => 'Giày chạy bộ nam (màu sáng)', 'price' => 99, 'image' => 'user/images/card-item2.jpg', 'description' => 'Thiết kế thời trang, màu sắc tươi sáng.'],
            ['sku' => 'p3', 'name' => 'Giày thể thao đỏ', 'price' => 99, 'image' => 'user/images/card-item3.jpg', 'description' => 'Độ bám tốt, thích hợp cho tập luyện.'],
            ['sku' => 'p4', 'name' => 'Giày thời trang nữ', 'price' => 99, 'image' => 'user/images/card-item4.jpg', 'description' => 'Phong cách tối giản, phù hợp đi dạo.'],
            ['sku' => 'p5', 'name' => 'Giày Sneaker', 'price' => 99, 'image' => 'user/images/card-item5.jpg', 'description' => 'Sneaker cổ điển, dễ phối đồ.'],
            ['sku' => 'p6', 'name' => 'Giày mới 6', 'price' => 99, 'image' => 'user/images/card-item6.jpg', 'description' => 'Sản phẩm mới.'],
            ['sku' => 'p7', 'name' => 'Giày mới 7', 'price' => 99, 'image' => 'user/images/card-item7.jpg', 'description' => 'Sản phẩm mới.'],
            ['sku' => 'p8', 'name' => 'Giày mới 8', 'price' => 99, 'image' => 'user/images/card-item8.jpg', 'description' => 'Sản phẩm mới.'],
            ['sku' => 'p9', 'name' => 'Giày mới 9', 'price' => 99, 'image' => 'user/images/card-item9.jpg', 'description' => 'Sản phẩm mới.'],
            ['sku' => 'p10', 'name' => 'Giày mới 10', 'price' => 99, 'image' => 'user/images/card-item10.jpg', 'description' => 'Sản phẩm mới.'],
        ];

        // Ensure at least one category exists
        $category = Category::firstOrCreate(
            ['slug' => 'uncategorized'],
            ['name' => 'Uncategorized', 'description' => 'Default category']
        );

        foreach ($examples as $row) {
            Product::updateOrCreate(
                ['sku' => $row['sku']],
                array_merge($row, ['is_active' => 1, 'category_id' => $category->id])
            );
        }
    }
}
