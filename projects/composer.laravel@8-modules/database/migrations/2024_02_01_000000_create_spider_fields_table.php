<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Support\Module;

class CreateSpiderFieldsTable extends \App\Illuminate\Database\Migrations\Migration
{
    protected $prefix = "";
    protected $tableName = "_spider_fields";
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
        // 基本标记表
        Schema::create($tableName, function (Blueprint $table) {
            $table->id()->comment("爬虫编号");

            $table->string('name')->nullable()->comment('字段名称');
            $table->string('selector_type')->nullable()->default('xpath')->comment('');
            $table->string('selector')->nullable()->comment('');
            $table->boolean('required')->nullable()->comment('');
            $table->boolean('repeated')->nullable()->comment('');

            $table->string('source_type')->nullable()->comment('');
            $table->string('attached_url')->nullable()->comment('');

            $table->string('parent')->nullable()->comment('父本');

            $table->unique(['id', 'name']);
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
