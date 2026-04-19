<?php

use App\Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends \App\Illuminate\Database\Migrations\Migration
{
    protected $prefix = "";
    protected $tableName = "_files";
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
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();

            $table->string('slug')->nullable()->unique()->comment('标识');

            $table->string('name')->nullable()->comment('标题');
            $table->string('path')->nullable()->comment('路径');

            $table->string('type')->nullable()->comment('类型');
            $table->string('status')->nullable()->comment('状态');

            $table->integer('template')->nullable()->default(0)->comment('模板');

            $table->integer('count')->nullable()->default(0)->comment('计数');
            $table->integer('order')->nullable()->default(0)->comment('权重');
            $table->integer('parent')->nullable()->default(0)->comment('父本');

            $table->string('mime_type')->nullable()->comment('标准类型');

            $table->integer("user_id")->default(0)->comment("用户编号");

            $table->timestamps();
            $table->timestamp('release_at')->nullable()->comment('发布时间');
            $table->timestamp('deleted_at')->nullable()->comment('删除时间');
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
