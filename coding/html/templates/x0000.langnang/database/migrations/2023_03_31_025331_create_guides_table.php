<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('guides', function (Blueprint $table) {
      $table->increments('id')->comment("编号");
      $table->string("name")->nullable()->comment('名称');
      $table->string("slug")->nullable()->comment('别名')->unique();
      $table->string("ico")->nullable()->comment('徽标');
      $table->string("url")->nullable()->comment('地址');
      $table->string("description")->nullable()->comment('说明');
      $table->string("type", 25)->nullable()->default("site")->comment("类型: branch, category, site");
      $table->string('status')->nullable()->default('draft')->comment("状态: public, private, draft");
      $table->integer('user')->nullable()->default(0)->comment('用户 ID');
      $table->integer('count')->nullable()->default(0)->comment('计数');
      $table->integer('order')->nullable()->default(0)->comment('权重');
      $table->integer('parent')->nullable()->default(0)->comment('父本');
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
    Schema::dropIfExists('guides');
  }
}
