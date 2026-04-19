<?php

namespace Database\Seeders;

use App\Illuminate\Database\Seeder;

class SpiderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::insertOrIgnore([
            "name" => "langnang",
            "email" => "langnang.chen@outlook.com",
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
    }
}
