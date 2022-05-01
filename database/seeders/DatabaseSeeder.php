<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PrefectureSeeder::class);


        Admin::updateOrCreate(
            ['email' => 'admin@admin.com'],
            ['password' => Hash::make('password'), 'name' => 'Admin']
        );
    }
}
