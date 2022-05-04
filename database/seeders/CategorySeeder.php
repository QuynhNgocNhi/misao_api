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
                'image_path' => '/images/categories/rauCuQua.webp'
            ],
            [
                'name' => 'Trái cây',
                'image_path' => '/images/categories/traiCay.webp'
            ],
            [
                'name' => 'Thịt, trứng',
                'image_path' => '/images/categories/thitTrung.webp'
            ],
            [
                'name' => 'Sữa, bơ, phô mai',
                'image_path' => '/images/categories/sua.webp'
            ],
            [
                'name' => 'Bánh kẹo',
                'image_path' => '/images/categories/banh-keo.png'
            ],
            [
                'name' => 'Nguyên liệu',
                'image_path' => '/images/categories/nguyenLieu.webp'
            ],
            [
                'name' => 'Thực phẩm Việt',
                'image_path' => '/images/categories/thucPhamViet.webp'
            ],
            [
                'name' => 'Gạo',
                'image_path' => '/images/categories/gao.webp'
            ],
            [
                'name' => 'Cá',
                'image_path' => '/images/categories/ca.webp'
            ],
            [
                'name' => 'Dụng cụ',
                'image_path' => '/images/categories/dungCu.webp'
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
