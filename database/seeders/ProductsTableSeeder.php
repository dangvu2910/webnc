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
            ['sku' => 'p1', 'name' => 'Nike Dunk Low Blue', 'price' => 499000, 'image' => 'user/images/card-item1.jpg', 'description' => 'Giày Nike Dunk Low với màu xanh lam nổi bật, phù hợp cho hàng ngày.'],
            ['sku' => 'p2', 'name' => 'Nike Air Force 1', 'price' => 599000, 'image' => 'user/images/card-item2.jpg', 'description' => 'Giày Air Force 1 cổ điển với thiết kế hai tông màu.'],
            ['sku' => 'p3', 'name' => 'Nike Free RN', 'price' => 699000, 'image' => 'user/images/card-item3.jpg', 'description' => 'Giày Nike Free RN màu đỏ, nhẹ nhàng và thoải mái.'],
            ['sku' => 'p4', 'name' => 'Nike Revolution', 'price' => 799000, 'image' => 'user/images/card-item4.jpg', 'description' => 'Giày chạy bộ Nike Revolution với thiết kế hiện đại.'],
            ['sku' => 'p5', 'name' => 'Nike Court Borough', 'price' => 899000, 'image' => 'user/images/card-item5.jpg', 'description' => 'Giày Nike Court Borough với phong cách thể thao cổ điển.'],
            ['sku' => 'p6', 'name' => 'Adidas Stan Smith', 'price' => 499000, 'image' => 'user/images/card-item6.jpg', 'description' => 'Giày Adidas Stan Smith kinh điển, đơn giản và thanh lịch.'],
            ['sku' => 'p7', 'name' => 'Adidas NMD R1', 'price' => 599000, 'image' => 'user/images/card-item7.jpg', 'description' => 'Giày Adidas NMD R1 hiện đại với công nghệ boost.'],
            ['sku' => 'p8', 'name' => 'New Balance 990', 'price' => 699000, 'image' => 'user/images/card-item8.jpg', 'description' => 'Giày New Balance 990 với sự kết hợp hoàn hảo giữa thoải mái và phong cách.'],
            ['sku' => 'p9', 'name' => 'Puma RS-X Reinvention', 'price' => 799000, 'image' => 'user/images/card-item9.jpg', 'description' => 'Giày Puma RS-X với thiết kế độc đáo và nổi bật.'],
            ['sku' => 'p10', 'name' => 'Converse Chuck Taylor', 'price' => 899000, 'image' => 'user/images/card-item10.jpg', 'description' => 'Giày Converse Chuck Taylor All Star, biểu tượng của văn hóa sneaker.'],
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
