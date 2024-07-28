<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'code' => '1',
            'brand_id' => 1,
            'category_id' => 1,
            'variant_id' => 1,
            'name' => 'Pakaian Muslim Wanita',
            'discount' => 0,
            'buying_price' => 5000,
            'selling_price' => 10000,
            'stock' => 100,
        ]);
    }
}
