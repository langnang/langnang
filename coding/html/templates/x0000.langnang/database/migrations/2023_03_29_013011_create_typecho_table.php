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
    Schema::create('typecho_metas', function (Blueprint $table) {
      $table->increments('mid');
      $table->timestamps();
    });
    Schema::create('typecho_contents', function (Blueprint $table) {
      $table->increments('cid')->comment("编号");
      $table->string('name')->nullable()->comment("名称");
      $table->string('slug')->unique()->nullable()->comment("编码");
      $table->string('type')->nullable()->comment("类型: book, menu, article, chapter, snippet");
      $table->text('text')->nullable()->comment("内容");
      $table->text('template')->nullable()->comment("模板");
      $table->string('status')->default('draft')->nullable()->comment("状态: public, private, draft");
      $table->integer('count')->default(0)->nullable()->comment("计数");
      $table->integer('order')->default(0)->nullable()->comment("权重");
      $table->integer('parent')->default(0)->nullable()->comment("父本");
      $table->timestamps();
    });
    Schema::create('typecho_fields', function (Blueprint $table) {
      $table->increments('mid');
    });
    Schema::create('typecho_relationships', function (Blueprint $table) {
      $table->integer("mid");
      $table->integer("cid");
    });
    Schema::create('typecho_options', function (Blueprint $table) {
      $table->timestamps();
    });
    Schema::create('typecho_comments', function (Blueprint $table) {
      $table->timestamps();
    });
    Schema::create('typecho_users', function (Blueprint $table) {
      $table->increments('uid')->comment("编号");
      $table->string('name')->nullable()->comment("名称");
      $table->string('slug')->unique()->nullable()->comment("编码");
      $table->string('type')->nullable()->comment("类型");
      $table->text('description')->nullable()->comment("说明");
      $table->string('status')->default('draft')->nullable()->comment("状态：public、private、draft");
      $table->integer('count')->default(0)->nullable()->comment("计数");
      $table->integer('order')->default(0)->nullable()->comment("权重");
      $table->integer('parent')->default(0)->nullable()->comment("父本");
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('typecho_metas');
    Schema::dropIfExists('typecho_contents');
    Schema::dropIfExists('typecho_fields');
    Schema::dropIfExists('typecho_relationships');
    Schema::dropIfExists('typecho_options');
    Schema::dropIfExists('typecho_comments');
    Schema::dropIfExists('typecho_users');
  }
}
