<?php

namespace Modules\WebNav\Database\Seeders;

use App\Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class WebNavDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $modules = \App\Models\Meta::getRootModules();

        \App\Models\Meta::upsert(
            array_map(function ($module) {
                return [
                    'name' => 'WebHunt',
                    'slug' => $module['slug'] . ':webhunt',
                    'type' => 'nav',
                    'status' => 'public',
                    'parent' => $module['id'],
                ];
            },  $modules->all()),
            ['slug'],
            ['name', 'slug', 'type', 'status']
        );
        // $this->call("OthersTableSeeder");
        $parent = \App\Models\Meta::where('slug', 'webnav')->where('user_id', 0)->first()->id;
        if (empty($parent)) return;

        // foreach (\App\Models\Meta::factory(30)->make() as $meta) {
        //     $meta->parent = $parent;
        //     $meta->user_id = $meta->user_id ?? 0;
        //     $meta->save();
        // }
        // \Modules\WebNav\Models\WebNav::factory(30)->create();
    }
}
