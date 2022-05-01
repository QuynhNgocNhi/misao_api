<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
            [
                'name' => 'Rau củ quả',
                'image_path' => '/images/categories/rau-cu-qua.jpeg'
            ],
            [
                'name' => 'Trái cây',
                'image_path' => '/images/categories/trai-cay.jpeg'
            ],
            [
                'name' => 'Thịt, trứng',
                'image_path' => '/images/categories/thit-trung.jpeg'
            ],
            [
                'name' => 'Sữa, bơ, phô mai',
                'image_path' => '/images/categories/sua-pho-mai.jpeg'
            ],
            [
                'name' => 'Bánh kẹo',
                'image_path' => '/images/categories/banh-keo.png'
            ]
        ];
        DB::table('categories')->truncate();
        $data = array_map(function ($item) {
            return array_merge($item, [
                'status'     => ACTIVE,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $input);
        DB::table('categories')->insert($data);

    }
}
