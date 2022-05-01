<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PrefectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => '北海道', 'romaji_name' => 'Hokkaido', 'area' => '北海道'],
            ['name' => '青森県', 'romaji_name' => 'Aomori', 'area' => '東北'],
            ['name' => '岩手県', 'romaji_name' => 'Iwate', 'area' => '東北'],
            ['name' => '宮城県', 'romaji_name' => 'Miyagi', 'area' => '東北'],
            ['name' => '秋田県', 'romaji_name' => 'Akita', 'area' => '東北'],
            ['name' => '山形県', 'romaji_name' => 'Yamagata', 'area' => '東北'],
            ['name' => '福島県', 'romaji_name' => 'Fukushima', 'area' => '東北'],
            ['name' => '茨城県', 'romaji_name' => 'Ibaraki', 'area' => '関東'],
            ['name' => '栃木県', 'romaji_name' => 'Tochigi', 'area' => '関東'],
            ['name' => '群馬県', 'romaji_name' => 'Gunma', 'area' => '関東'],
            ['name' => '埼玉県', 'romaji_name' => 'Saitama', 'area' => '関東'],
            ['name' => '千葉県', 'romaji_name' => 'Chiba', 'area' => '関東'],
            ['name' => '東京都', 'romaji_name' => 'Tokyo', 'area' => '関東'],
            ['name' => '神奈川県', 'romaji_name' => 'Kanagawa', 'area' => '関東'],
            ['name' => '新潟県', 'romaji_name' => 'Niigata', 'area' => '中部'],
            ['name' => '富山県', 'romaji_name' => 'Toyama', 'area' => '中部'],
            ['name' => '石川県', 'romaji_name' => 'Ishikawa', 'area' => '中部'],
            ['name' => '福井県', 'romaji_name' => 'Fukui', 'area' => '中部'],
            ['name' => '山梨県', 'romaji_name' => 'Yamanashi', 'area' => '中部'],
            ['name' => '長野県', 'romaji_name' => 'Nagano', 'area' => '中部'],
            ['name' => '岐阜県', 'romaji_name' => 'Gifu', 'area' => '中部'],
            ['name' => '静岡県', 'romaji_name' => 'Shizuoka', 'area' => '中部'],
            ['name' => '愛知県', 'romaji_name' => 'Aichi', 'area' => '中部'],
            ['name' => '三重県', 'romaji_name' => 'Mie', 'area' => '近畿'],
            ['name' => '滋賀県', 'romaji_name' => 'Shiga', 'area' => '近畿'],
            ['name' => '京都府', 'romaji_name' => 'Kyoto', 'area' => '近畿'],
            ['name' => '大阪府', 'romaji_name' => 'Osaka', 'area' => '近畿'],
            ['name' => '兵庫県', 'romaji_name' => 'Hyogo', 'area' => '近畿'],
            ['name' => '奈良県', 'romaji_name' => 'Nara', 'area' => '近畿'],
            ['name' => '和歌山県', 'romaji_name' => 'Wakayama', 'area' => '近畿'],
            ['name' => '鳥取県', 'romaji_name' => 'Tottori', 'area' => '中国'],
            ['name' => '島根県', 'romaji_name' => 'Shimane', 'area' => '中国'],
            ['name' => '岡山県', 'romaji_name' => 'Okayama', 'area' => '中国'],
            ['name' => '広島県', 'romaji_name' => 'Hiroshima', 'area' => '中国'],
            ['name' => '山口県', 'romaji_name' => 'Yamaguchi', 'area' => '中国'],
            ['name' => '徳島県', 'romaji_name' => 'Tokushima', 'area' => '四国'],
            ['name' => '香川県', 'romaji_name' => 'Kagawa', 'area' => '四国'],
            ['name' => '愛媛県', 'romaji_name' => 'Ehime', 'area' => '四国'],
            ['name' => '高知県', 'romaji_name' => 'Kochi', 'area' => '四国'],
            ['name' => '福岡県', 'romaji_name' => 'Fukuoka', 'area' => '九州'],
            ['name' => '佐賀県', 'romaji_name' => 'Saga', 'area' => '九州'],
            ['name' => '長崎県', 'romaji_name' => 'Nagasaki', 'area' => '九州'],
            ['name' => '熊本県', 'romaji_name' => 'Kumamoto', 'area' => '九州'],
            ['name' => '大分県', 'romaji_name' => 'Oita', 'area' => '九州'],
            ['name' => '宮崎県', 'romaji_name' => 'Miyazaki', 'area' => '九州'],
            ['name' => '鹿児島県', 'romaji_name' => 'Kagoshima', 'area' => '九州'],
            ['name' => '沖縄県', 'romaji_name' => 'Okinawa', 'area' => '九州'],
        ];
        \DB::table('prefectures')->truncate();
        \DB::table('prefectures')->insert($data);
    }
}
