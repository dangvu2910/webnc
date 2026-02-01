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
        Schema::table('users', function (Blueprint $table) {
            // Change is_admin to role: admin, staff, customer
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['customer', 'staff', 'admin'])->default('customer')->after('password');
            }
        });

        // Migrate existing is_admin data to role
        \DB::table('users')
            ->where('is_admin', true)
            ->update(['role' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
