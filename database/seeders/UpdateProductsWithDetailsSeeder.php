<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class UpdateProductsWithDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cập nhật các sản phẩm hiện có với thông tin chi tiết
        $products = Product::all();

        foreach ($products as $product) {
            // Chỉ cập nhật nếu chưa có thông tin chi tiết
            if (empty($product->brand)) {
                $brands = ['Nike', 'Adidas', 'Puma', 'Converse', 'Vans', 'New Balance', 'Reebok'];
                $materials = ['Da thật', 'Vải canvas', 'Cao su tổng hợp', 'Da nhân tạo', 'Microfiber', 'Nylon'];
                
                $product->update([
                    'brand' => $brands[array_rand($brands)],
                    'material' => $materials[array_rand($materials)],
                    'specifications' => 'Trọng lượng: 250g | Kích thước đế: Tiêu chuẩn | Độ co giãn: Tốt',
                    'rating' => rand(35, 50) / 10, // 3.5-5.0
                    'reviews_count' => rand(10, 150),
                    'warranty' => 'Bảo hành 1 năm toàn bộ sản phẩm',
                    'care_instructions' => 'Vệ sinh sạch sẽ bằng nước ấm và xà phòng nhẹ. Lưu trữ ở nơi khô ráo, tránh ánh nắng trực tiếp.',
                ]);
            }
        }

        $this->command->info('✓ Đã cập nhật thông tin chi tiết cho ' . $products->count() . ' sản phẩm!');
    }
}
