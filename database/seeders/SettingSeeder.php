<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            [
                'name' => 'Nibras House Wungu',
                'phone' => '081234779987',
                'address' => 'Jl.Kibandang Samaran Ds.Slangit',
            ]
        ]);
    }
}
