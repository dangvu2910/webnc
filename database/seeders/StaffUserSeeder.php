<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'staff@example.com';
        $password = 'staff123';

        if (!User::where('email', $email)->exists()) {
            User::create([
                'name' => 'Nhân viên',
                'username' => 'staff',
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'staff',
            ]);
            $this->command->info("Staff user created: $email / $password");
        } else {
            $this->command->info("Staff user already exists: $email");
        }
    }
}
