<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        Schema::create('spiders', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->nullable()->comment("名称");
            $table->string("slug")->nullable()->comment("标识");
            $table->string("description")->nullable()->comment();
            $table->string("type")->nullable()->comment();
            $table->string("status")->nullable()->comment();
            $table->json("domains")->nullable()->comment('域名');
            $table->json("scan_urls")->nullable()->comment('入口链接');
            $table->json("list_url_regexes")->nullable()->comment('列表页');
            $table->json("content_url_regexes")->nullable()->comment('内容页');
            $table->integer("count")->nullable()->default(0)->comment();
            $table->integer("order")->nullable()->default(0)->comment();
            $table->integer("parent")->nullable()->default(0)->comment();
            $table->timestamps();
        });
        Schema::create('spider_urls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('spider_id')->nullable();
            $table->timestamps();
        });
        Schema::create('spider_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('selector_type')->nullable()->default('xpath');
            $table->string('selector')->nullable();
            $table->string('filter')->nullable();
            $table->string('default')->nullable();
            $table->boolean('required')->nullable();
            $table->boolean('repeated')->nullable();
            $table->integer('parent')->nullable()->default(0)->comment();
            $table->integer('spider_id')->nullable();
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
        Schema::dropIfExists('spiders');
        Schema::dropIfExists('spider_urls');
        Schema::dropIfExists('spider_fields');
    }
}
