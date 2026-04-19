<?php

namespace Modules\Toolkit\Database\Seeders;

use App\Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ToolkitDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        $module = \App\Models\Meta::where('slug', 'toolkit')->first();
        // var_dump($module->id);
        if (empty($module)) return;

        $return = \App\Models\Meta::upsert(
            [
                ['slug' => 'toolkit:encryption', 'ico' => 'fas fa-tachometer-alt', 'name' => '加密类', 'type' => 'category', 'status' => 'public', 'order' => 1, 'parent' => $module->id],
                ['slug' => 'toolkit:decryption', 'ico' => 'fas fa-tachometer-alt', 'name' => '解密类', 'type' => 'category', 'status' => 'public', 'order' => 2, 'parent' => $module->id],
            ],
            ['slug'],
            ['slug', 'ico', 'name', 'type', 'status', 'order', 'parent']
        );
    }
}
