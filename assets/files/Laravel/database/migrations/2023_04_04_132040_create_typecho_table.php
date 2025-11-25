<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypechoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("typecho_metas", function (Blueprint $table) {
            $table->id("mid")->comment("编号");
            $table->string("name")->nullable()->comment("名称");
            $table->string("slug")->nullable()->unique()->comment("标识");

            $table->string("description")->nullable()->comment("说明");
            $table->string("type")->nullable()->comment("类型: branch, category, tag");
            $table->string("status")->nullable()->comment("状态");

            $table->integer("order")->nullable()->default(0)->comment("排序");
            $table->integer("count")->nullable()->default(0)->comment("计数");
            $table->integer("parent")->nullable()->default(0)->comment("父本");

            $table->timestamp("created_at")->nullable()->comment("创建时间");
            $table->timestamp("updated_at")->nullable()->comment("修改时间");
            $table->timestamp("release_at")->nullable()->comment("发布时间");
            $table->timestamp("deleted_at")->nullable()->comment("删除时间");
        });
        Schema::create("typecho_contents", function (Blueprint $table) {
            $table->id("cid")->comment("编号");
            $table->string("title")->nullable()->comment("标题");
            $table->string("slug")->nullable()->unique()->comment("标识");

            $table->longText("text")->nullable()->comment("内容");
            $table->string("type")->nullable()->comment("类型");
            $table->string("status")->nullable()->default('draft')->comment("状态: draft, private, public");
            $table->integer("template")->nullable()->default(0)->comment("模板");

            $table->integer('user',)->nullable()->default(0)->comment('用户ID');

            $table->integer("order")->nullable()->default(0)->comment("排序");
            $table->integer("count")->nullable()->default(0)->comment("计数");
            $table->integer("parent")->nullable()->default(0)->comment("父本");

            $table->timestamp("created_at")->nullable()->comment("创建时间");
            $table->timestamp("updated_at")->nullable()->comment("修改时间");
            $table->timestamp("release_at")->nullable()->comment("发布时间");
            $table->timestamp("deleted_at")->nullable()->comment("删除时间");
        });
        Schema::create("typecho_relationships", function (Blueprint $table) {
            $table->integer("mid")->comment("_metas");
            $table->integer("cid")->comment("_contents");
        });
        Schema::create("typecho_fields", function (Blueprint $table) {
            $table->id();
            $table->integer("cid")->comment("_contents");

            $table->integer("parent")->nullable()->default(0)->comment("父本");

            $table->timestamp("created_at")->nullable()->comment("创建时间");
            $table->timestamp("updated_at")->nullable()->comment("修改时间");
            $table->timestamp("release_at")->nullable()->comment("发布时间");
            $table->timestamp("deleted_at")->nullable()->comment("删除时间");
        });
        Schema::create("typecho_comments", function (Blueprint $table) {
            $table->integer("cid")->comment("_contents");

            $table->integer("order")->nullable()->default(0)->comment("排序");
            $table->integer("count")->nullable()->default(0)->comment("计数");
            $table->integer("parent")->nullable()->default(0)->comment("父本");

            $table->timestamp("created_at")->nullable()->comment("创建时间");
            $table->timestamp("updated_at")->nullable()->comment("修改时间");
            $table->timestamp("release_at")->nullable()->comment("发布时间");
            $table->timestamp("deleted_at")->nullable()->comment("删除时间");
        });
        Schema::create("typecho_links", function (Blueprint $table) {
            $table->id()->comment("编号");
            $table->string("title")->nullable()->comment("标题");
            $table->string("url")->nullable()->comment("地址");
            $table->string("ico")->nullable()->comment("徽标");
            $table->string("description")->nullable()->comment("说明");
            $table->string("type")->nullable()->comment("类型");
            $table->string("status")->nullable()->comment("状态");

            $table->integer("order")->nullable()->default(0)->comment("排序");
            $table->integer("count")->nullable()->default(0)->comment("计数");
            $table->integer("parent")->nullable()->default(0)->comment("父本");

            $table->timestamp("created_at")->nullable()->comment("创建时间");
            $table->timestamp("updated_at")->nullable()->comment("修改时间");
            $table->timestamp("release_at")->nullable()->comment("发布时间");
            $table->timestamp("deleted_at")->nullable()->comment("删除时间");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("typecho_metas");
        Schema::dropIfExists("typecho_contents");
        Schema::dropIfExists("typecho_relationships");
        Schema::dropIfExists("typecho_fields");
        Schema::dropIfExists("typecho_comments");
        Schema::dropIfExists("typecho_links");
    }
}
