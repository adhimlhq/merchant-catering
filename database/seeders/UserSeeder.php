<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Membuat Admin
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'phone_number' => '1234567890',
            'password' => Hash::make('password123'),
        ]);

        // Membuat Merchant
        User::create([
            'first_name' => 'Merchant',
            'last_name' => 'One',
            'email' => 'merchant1@example.com',
            'role' => 'merchant',
            'phone_number' => '0987654321',
            'password' => Hash::make('password123'),
        ]);

        // Membuat Merchant (contoh kedua)
        User::create([
            'first_name' => 'Merchant',
            'last_name' => 'Two',
            'email' => 'merchant2@example.com',
            'role' => 'merchant',
            'phone_number' => '1122334455',
            'password' => Hash::make('password123'),
        ]);

        // Membuat Customer
        User::create([
            'first_name' => 'Customer',
            'last_name' => 'User',
            'email' => 'customer@example.com',
            'role' => 'customer',
            'phone_number' => '5566778899',
            'password' => Hash::make('password123'),
        ]);
    }
}
