<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Pakaian Muslim Wanita',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pakaian Muslim Pria',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pakaian Muslim Anak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pakaian Ibadah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jilbab',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Parfum',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
