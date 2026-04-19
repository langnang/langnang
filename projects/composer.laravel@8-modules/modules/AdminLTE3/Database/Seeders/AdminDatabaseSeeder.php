<?php

namespace Modules\Admin\Database\Seeders;

use App\Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Storage;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::enableQueryLog();

        Model::unguard();

        // $this->call("OthersTableSeeder");
        $adminMeta = \App\Models\Meta::where('slug', 'admin')->first();
        // var_dump($adminMeta);
        if (empty($adminMeta)) return;

        \App\Models\Meta::upsert(
            [
                ['slug' => 'admin:dashboard', 'ico' => 'fas fa-tachometer-alt', 'name' => '仪表板', 'type' => 'category', 'status' => 'public', 'order' => 1, 'parent' => $adminMeta->id],
                ['slug' => 'admin:ssential', 'ico' => 'fas fa-tachometer-alt', 'name' => '聚合数据', 'type' => 'category', 'status' => 'public', 'order' => 2, 'parent' => $adminMeta->id],
                ['slug' => 'admin:modules', 'ico' => 'fas fa-tachometer-alt', 'name' => '模块管理', 'type' => 'category', 'status' => 'public', 'order' => 3, 'parent' => $adminMeta->id],
                ['slug' => 'admin:framework', 'ico' => 'fas fa-tachometer-alt', 'name' => '框架管理', 'type' => 'category', 'status' => 'public',  'order' => 4, 'parent' => $adminMeta->id],
                ['slug' => 'admin:system', 'ico' => 'fas fa-tachometer-alt', 'name' => '系统管理', 'type' => 'category', 'status' => 'public',  'order' => 5, 'parent' => $adminMeta->id],
            ],
            ['slug'],
            ['slug', 'ico', 'name', 'type', 'status', 'order', 'parent']
        );
        $adminSsentialMeta = \App\Models\Meta::where('slug', 'admin:ssential')->first();
        \App\Models\Meta::upsert(
            [
                ['slug' => 'admin:ssential:metas', 'ico' => '', 'name' => 'Metas', 'type' => 'category', 'status' => 'public', 'parent' => $adminSsentialMeta->id],
                ['slug' => 'admin:ssential:contents', 'ico' => '', 'name' => 'Contents', 'type' => 'category', 'status' => 'public', 'parent' => $adminSsentialMeta->id],
                ['slug' => 'admin:ssential:links', 'ico' => '', 'name' => 'Links', 'type' => 'category', 'status' => 'public', 'parent' => $adminSsentialMeta->id],
                ['slug' => 'admin:ssential:files', 'ico' => '', 'name' => 'Files', 'type' => 'category', 'status' => 'public', 'parent' => $adminSsentialMeta->id],
                ['slug' => 'admin:ssential:spiders', 'ico' => '', 'name' => 'Spiders', 'type' => 'category', 'status' => 'public', 'parent' => $adminSsentialMeta->id],
            ],
            ['slug'],
            ['slug', 'ico', 'name', 'type', 'status', 'parent']
        );

        $adminModulesMeta = \App\Models\Meta::where('slug', 'admin:modules')->first();
        foreach (\Module::allEnabled() as $moduleName => $moduleObject) {
            if (!in_array($moduleName, ['Admin']))
                \App\Models\Meta::upsert(
                    ['slug' => 'admin:modules:' . $moduleObject->getAlias(), 'ico' => '', 'name' => $moduleName, 'type' => 'category', 'status' => config($moduleObject->getAlias() . '.status', 'public'), 'parent' => $adminModulesMeta->id],
                    ['slug'],
                    ['slug', 'ico', 'name', 'type', 'status', 'parent']
                );
            // $moduleMeta = \App\Models\Meta::where('slug', '' . $module->getAlias())->where('user', 0)->first();
            // foreach ($globalMetaStatusOption as $globalStatus) {
            //     $status = $globalStatus['value'];
            //     \App\Models\Meta::upsert(
            //         ['slug' => '' . $module->getAlias() . ':' . $status, 'type' => 'module-status', 'status' => $status, 'parent' => $moduleMeta],
            //         ['slug'],
            //         ['type', 'status']
            //     );
            // }
        }

        $adminFrameworkMeta = \App\Models\Meta::where('slug', 'admin:framework')->first();
        \App\Models\Meta::upsert(
            [
                ['slug' => 'admin:framework:options', 'ico' => '', 'name' => 'Options', 'type' => 'category', 'status' => 'public', 'parent' => $adminFrameworkMeta->id],
                ['slug' => 'admin:framework:caches', 'ico' => '', 'name' => 'Caches', 'type' => 'category', 'status' => 'public', 'parent' => $adminFrameworkMeta->id],
                ['slug' => 'admin:framework:sessions', 'ico' => '', 'name' => 'Sessions', 'type' => 'category', 'status' => 'public', 'parent' => $adminFrameworkMeta->id],
                ['slug' => 'admin:framework:logs', 'ico' => '', 'name' => 'Logs', 'type' => 'category', 'status' => 'public', 'parent' => $adminFrameworkMeta->id],
                ['slug' => 'admin:framework:migrations', 'ico' => '', 'name' => 'Migrations', 'type' => 'category', 'status' => 'public', 'parent' => $adminFrameworkMeta->id],
                ['slug' => 'admin:framework:seeders', 'ico' => '', 'name' => 'Seeders', 'type' => 'category', 'status' => 'public', 'parent' => $adminFrameworkMeta->id],
            ],
            ['slug'],
            ['slug', 'ico', 'name', 'type', 'status', 'parent']
        );

        $adminSystemMeta = \App\Models\Meta::where('slug', 'admin:system')->first();
        // var_dump(\DB::getQueryLog());
        \App\Models\Meta::upsert(
            [
                ['slug' => 'admin:system:market', 'ico' => '', 'name' => '应用市场', 'type' => 'category', 'status' => 'public', 'parent' => $adminSystemMeta->id],
                ['slug' => 'admin:system:user', 'ico' => '', 'name' => '用户管理', 'type' => 'category', 'status' => 'public', 'parent' => $adminSystemMeta->id],
                ['slug' => 'admin:system:database', 'ico' => '', 'name' => '数据管理', 'type' => 'category', 'status' => 'public', 'parent' => $adminSystemMeta->id],
                ['slug' => 'admin:system:storage', 'ico' => '', 'name' => '资源管理', 'type' => 'category', 'status' => 'public', 'parent' => $adminSystemMeta->id],
            ],
            ['slug'],
            ['slug', 'ico', 'name', 'type', 'status', 'parent']
        );
        \DB::disableQueryLog();
    }
}
