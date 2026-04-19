<?php

namespace Database\Seeders;

use App\Illuminate\Database\Seeder;

class MetaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Meta::upsert(array_merge([[
            'name' =>  config('home.nameCn', '首页') . "·Home",
            'slug' => 'home',
            'description' => static::class,
            'type' => 'module',
            'status' => 'public',
        ]], array_map(function ($module) {
            return [
                'name' =>  config($module->getAlias() . '.nameCn') . "·" . $module,
                'slug' =>  $module->getAlias(),
                'description' =>  static::class,
                'type' => config($module->getAlias() . '.type', 'module'),
                'status' => config($module->getAlias() . '.status', 'public')
            ];
        }, \Module::allEnabled())), ['slug'], ['name', 'slug', 'description', 'type', 'status']);
    }
}
