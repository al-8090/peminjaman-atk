<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama
        User::create([
            'name' => 'Admin Sarpras',
            'email' => 'admin@cakrawala.co.id',
            'password' => Hash::make('password'),
        ]);

        // 2. Kategori Peralatan
        $catLaptop = Category::create([
            'name' => 'Laptop & Komputer',
            'description' => 'Perangkat kerja komputasi mobile dan desktop',
        ]);
        $catDisplay = Category::create([
            'name' => 'Proyektor & Display',
            'description' => 'Perangkat presentasi ruang meeting',
        ]);
        $catAudio = Category::create([
            'name' => 'Audio & Kamera',
            'description' => 'Perangkat dokumentasi dan konferensi',
        ]);

        // 3. Data Peralatan Kantor
        Equipment::create([
            'category_id' => $catLaptop->id,
            'code' => 'ATK-LPT-001',
            'name' => 'MacBook Pro M2 14"',
            'stock' => 5,
        ]);
        Equipment::create([
            'category_id' => $catLaptop->id,
            'code' => 'ATK-LPT-002',
            'name' => 'Lenovo ThinkPad X1 Carbon',
            'stock' => 8,
        ]);
        Equipment::create([
            'category_id' => $catDisplay->id,
            'code' => 'ATK-PRJ-001',
            'name' => 'Proyektor Epson EB-X500',
            'stock' => 4,
        ]);
        Equipment::create([
            'category_id' => $catAudio->id,
            'code' => 'ATK-CAM-001',
            'name' => 'Kamera Sony Alpha A6400',
            'stock' => 3,
        ]);

        // 4. Data Pegawai Peminjam
        Employee::create([
            'nip' => '20260101',
            'name' => 'Budi Santoso',
            'department' => 'Engineering',
            'phone' => '081234567890',
        ]);
        Employee::create([
            'nip' => '20260102',
            'name' => 'Siti Aminah',
            'department' => 'Human Resources',
            'phone' => '081298765432',
        ]);
        Employee::create([
            'nip' => '20260103',
            'name' => 'Rizky Pratama',
            'department' => 'Marketing',
            'phone' => '081345678901',
        ]);
    }
}
