<?php

namespace Modules\WebFrame\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class WebFrameDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $module = \App\Models\Meta::where('slug', 'webframe')->first();
        if (!$module) return;

        \App\Models\Meta::upsert(
            [
                ['name' => '搜索引擎', 'slug' => 'webframe:search-engine', 'type' => 'module', 'status' => 'public', 'parent' => $module->id]
            ],
            ['slug'],
            ['name', 'slug', 'type', 'status', 'parent']
        );
        $webFrameSearch = \App\Models\Meta::where('slug', 'webframe:search-engine')->first();

        $searchEngineLink = \App\Models\Link::whereIn('slug', ['baidu', 'bing'])->get();

        foreach ($searchEngineLink as $link) {
            \App\Models\Relationship::upsert([
                ['meta_id' => $webFrameSearch->id, 'link_id' => $link->id]
            ], ['meta_id', 'link_id'], ['meta_id', 'link_id']);
        }
        // $this->call("OthersTableSeeder");

        Model::reguard();
    }
}
