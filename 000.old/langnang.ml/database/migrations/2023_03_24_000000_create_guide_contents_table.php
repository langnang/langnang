<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuideContentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('guide_contents', function (Blueprint $table) {
      $table->integer('id')->autoIncrement()->comment("编号");
      $table->string('name')->nullable()->comment("名称");
      $table->string('slug')->unique()->nullable()->comment("编码");
      $table->string('icon')->nullable()->comment("徽标");
      $table->string('url')->nullable()->comment("地址");
      $table->string('description')->nullable()->comment("说明");
      $table->string('type')->nullable()->comment("类型: branch, category, site");
      $table->string('status')->default('draft')->nullable()->comment("状态: public, private, draft");
      $table->integer('count')->default(0)->nullable()->comment("计数");
      $table->integer('order')->default(0)->nullable()->comment("权重");
      $table->integer('parent')->default(0)->nullable()->comment("父本");
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
    Schema::dropIfExists('guide_contents');
  }
}
