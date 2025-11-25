<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebStackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("webstack_metas", function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment("名称");
            $table->string('slug')->nullable()->comment("标识");
            $table->string('logo')->nullable()->comment("徽标");
            $table->string('description')->nullable()->comment("描述");
            $table->string('type')->nullable()->comment('类型：category, tag, branch, option');
            $table->string('status')->nullable()->comment('状态');
            $table->integer('parent')->nullable()->default(0)->comment('父本');
            $table->integer('count')->nullable()->default(0)->comment('计数');
            $table->integer('order')->nullable()->default(0)->comment('排序');
            $table->timestamps();
        });
        Schema::create("webstack_contents", function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment("名称");
            $table->string('slug')->nullable()->comment("标识");
            $table->string('logo')->nullable()->comment("徽标");
            $table->string('description')->nullable()->comment("描述");
            $table->string('type')->nullable()->comment('类型');
            $table->string('status')->nullable()->comment('状态');
            $table->integer('parent')->nullable()->default(0)->comment('父本');
            $table->integer('count')->nullable()->default(0)->comment('计数');
            $table->integer('order')->nullable()->default(0)->comment('排序');
            $table->timestamps();
        });
        Schema::create("webstack_relationships", function (Blueprint $table) {
            $table->interger("meta_id");
            $table->interger("content_id");
        });
        Schema::create("webstack_links", function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment("名称");
            $table->string('slug')->nullable()->comment("标识");
            $table->string('logo')->nullable()->comment("徽标");
            $table->string('description')->nullable()->comment("描述");
            $table->string('type')->nullable()->comment('类型');
            $table->string('status')->nullable()->comment('状态');
            $table->integer('count')->nullable()->default(0)->comment('计数');
            $table->integer('order')->nullable()->default(0)->comment('排序');
            $table->interger("content_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webstack_metas');
        Schema::dropIfExists('webstack_contents');
        Schema::dropIfExists('webstack_relationships');
        Schema::dropIfExists('webstack_links');
    }
}
