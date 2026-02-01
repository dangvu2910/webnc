<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('webnc_products', function (Blueprint $table) {
            // Add new columns for better product info
            $table->string('brand')->nullable()->after('color'); // Thương hiệu
            $table->string('material')->nullable()->after('brand'); // Chất liệu
            $table->text('specifications')->nullable()->after('material'); // Thông số kỹ thuật
            $table->decimal('rating', 3, 2)->default(0)->after('specifications'); // Đánh giá (0-5)
            $table->integer('reviews_count')->default(0)->after('rating'); // Số lượng đánh giá
            $table->integer('views_count')->default(0)->after('reviews_count'); // Số lượt xem
            $table->integer('sales_count')->default(0)->after('views_count'); // Số lượng bán
            $table->text('warranty')->nullable()->after('sales_count'); // Bảo hành
            $table->text('care_instructions')->nullable()->after('warranty'); // Hướng dẫn bảo quản
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('webnc_products', function (Blueprint $table) {
            $table->dropColumn([
                'brand',
                'material',
                'specifications',
                'rating',
                'reviews_count',
                'views_count',
                'sales_count',
                'warranty',
                'care_instructions'
            ]);
        });
    }
};
