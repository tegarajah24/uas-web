<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin_resepsionis', 'dokter', 'farmasi', 'kasir'];

        foreach ($roles as $role) {
            Role::create(['name' => $role, 'guard_name' => 'web']);
        }

        User::factory()->create([
            'name' => 'Resepsionis',
            'email' => 'resepsionis@simrs.test',
            'password' => bcrypt('password'),
        ])->assignRole('admin_resepsionis');

        User::factory()->create([
            'name' => 'Dr. Andi',
            'email' => 'dokter@simrs.test',
            'password' => bcrypt('password'),
        ])->assignRole('dokter');

        User::factory()->create([
            'name' => 'Farmasi',
            'email' => 'farmasi@simrs.test',
            'password' => bcrypt('password'),
        ])->assignRole('farmasi');

        User::factory()->create([
            'name' => 'Kasir',
            'email' => 'kasir@simrs.test',
            'password' => bcrypt('password'),
        ])->assignRole('kasir');

        $medicines = [
            ['name' => 'Paracetamol', 'unit' => 'tablet', 'price' => 5000, 'stock' => 100],
            ['name' => 'Amoxicillin', 'unit' => 'tablet', 'price' => 10000, 'stock' => 50],
            ['name' => 'Ibuprofen', 'unit' => 'tablet', 'price' => 8000, 'stock' => 80],
            ['name' => 'Cetirizine', 'unit' => 'tablet', 'price' => 6000, 'stock' => 60],
            ['name' => 'Antasida Doen', 'unit' => 'tablet', 'price' => 4000, 'stock' => 120],
            ['name' => 'Obat Batuk Sirup', 'unit' => 'botol', 'price' => 15000, 'stock' => 30],
        ];

        foreach ($medicines as $med) {
            Medicine::create($med);
        }
    }
}
