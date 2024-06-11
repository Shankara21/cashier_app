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
                'name' => 'Pakaian Wanita',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pakaian Pria',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pakaian Anak',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
