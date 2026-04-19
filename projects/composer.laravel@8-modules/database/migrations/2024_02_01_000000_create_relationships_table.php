<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Support\Module;

class CreateRelationshipsTable extends \App\Illuminate\Database\Migrations\Migration
{
    protected $prefix = "";
    protected $tableName = "_relationships";
    protected $status = "private";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!$tableName = $this->getTableName())
            return;
        // 基本关联表
        Schema::create($tableName, function (Blueprint $table) {
            $table->integer('meta_id')->nullable()->comment("Meta");
            $table->integer('content_id')->nullable()->comment("Content");
            $table->integer('link_id')->nullable()->comment("Link");
            $table->integer('file_id')->nullable()->comment("File");
            foreach (\Module::allEnabled() as $moduleName => $moduleObject) {
                $table->integer($moduleObject->getAlias() . '_meta_id')->nullable()->comment($moduleName . "Meta");
                $table->integer($moduleObject->getAlias() . '_content_id')->nullable()->comment($moduleName . "Content");
                $table->integer($moduleObject->getAlias() . '_link_id')->nullable()->comment($moduleName . "Link");
                $table->integer($moduleObject->getAlias() . '_file_id')->nullable()->comment($moduleName . "File");
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!$tableName = $this->getTableName())
            return;
        Schema::dropIfExists($tableName);
    }
}
