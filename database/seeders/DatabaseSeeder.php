<?php

namespace Database\Seeders;

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
    }
}
