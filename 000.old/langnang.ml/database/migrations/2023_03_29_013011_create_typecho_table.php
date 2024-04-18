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
      $table->increments('cid');
      $table->timestamps();
    });
    Schema::create('typecho_relationships', function (Blueprint $table) {
      $table->integer("mid");
      $table->integer("cid");
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
    Schema::dropIfExists('typecho');
  }
}
