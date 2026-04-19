<?php

namespace Database\Seeders;

use App\Illuminate\Database\Seeder;

class ModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(array_map(function ($moduleName) {
            return "\Modules\\" . $moduleName . "\Database\Seeders\\" . $moduleName . "DatabaseSeeder";
        }, array_keys(\Module::allEnabled())));

        $globalMetaStatusOption = unserialize(\App\Models\Option::where('name', 'global.status')->where('user_id', 0)->first('value')->value);
        // var_dump($globalMetaStatusOption);


        //
        // \App\Models\Meta::upsert(
        //     ['name' => "Module:Home", 'slug' => 'module:home', 'type' => 'module', 'status' => 'public'],
        //     ['slug'],
        //     ['name', 'type', 'status']
        // );
        $module = \App\Models\Meta::where([['slug', 'module:home'], ['parent', 0]])->first('id')['id'];
        //   
        // \App\Models\Relationship::factory(10)->create([
        //     'meta_id'=>$module->id,
        // ]);
        // \App\Models\Meta::factory()->count(1)->has(\App\Models\Content::factory()->count(10),'contents')->create([
        //     'description' => __METHOD__,
        //     'parent' => $module
        // ]);
        // foreach (\App\Models\Meta::factory()->times(100)->make() as $meta) {
        //     $meta->parent = $moduleId;
        //     $meta->save();
        // }

        // \App\Models\Content::insertGetId(\App\Models\Meta::factory()->times(100)->make()->toArray());
        // $ids =   \App\Models\Content::factory(1)->insertGetId();
        // var_dump($ids);
        foreach (\Module::allEnabled() as $moduleName => $moduleObject) {
            // \App\Models\Meta::upsert(
            //     ['name' => "Module:" . $moduleName, 'slug' => 'module:' . $moduleObject->getAlias(), 'type' => 'module', 'status' => config($moduleObject->getAlias() . '.status', 'public')],
            //     ['slug'],
            //     ['name', 'type', 'status']
            // );
            // $moduleMeta = \App\Models\Meta::where('slug', 'module:' . $module->getAlias())->where('user', 0)->first();
            // foreach ($globalMetaStatusOption as $globalStatus) {
            //     $status = $globalStatus['value'];
            //     \App\Models\Meta::upsert(
            //         ['slug' => 'module:' . $module->getAlias() . ':' . $status, 'type' => 'module-status', 'status' => $status, 'parent' => $moduleMeta->id],
            //         ['slug'],
            //         ['type', 'status']
            //     );
            // }
        }
    }
}
