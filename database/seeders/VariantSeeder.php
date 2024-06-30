<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories_sizes = [
            1 => ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'],
            2 => ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'],
            3 => range(1, 13),
            4 => range(1, 10),
        ];

        $data = [];

        foreach ($categories_sizes as $category_id => $sizes) {
            foreach ($sizes as $size) {
                $data[] = [
                    'category_id' => $category_id,
                    'name' => (string)$size,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('variants')->insert($data);
    }
}
