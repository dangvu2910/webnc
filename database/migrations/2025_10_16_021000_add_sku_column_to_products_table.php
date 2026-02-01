<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('webnc_products', function (Blueprint $table) {
            if (! Schema::hasColumn('webnc_products', 'sku')) {
                $table->string('sku')->nullable()->unique()->after('id');
            }
        });
    }

    public function down()
    {
        Schema::table('webnc_products', function (Blueprint $table) {
            if (Schema::hasColumn('webnc_products', 'sku')) {
                $table->dropUnique(['sku']);
                $table->dropColumn('sku');
            }
        });
    }
};
