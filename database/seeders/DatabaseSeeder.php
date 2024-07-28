<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Hamcrest\Core\Set;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            CategorySeeder::class,
            SettingSeeder::class,
            VariantSeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
        ]);
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('admin');
        User::factory()->create([
            'name' => 'Lazuardi',
            'email' => 'lazuardit@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('admin');
        User::factory()->create([
            'name' => 'Budi',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('cashier');
    }
}
