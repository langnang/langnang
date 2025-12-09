<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebstackTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('webstack_metas', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('parent_id')->default(0);
      $table->integer('order')->default(0);
      $table->string('title', 50);
      $table->string('icon', 20);
      $table->timestamps();
    });

    Schema::create('webstack_sites', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('category_id');
      $table->string('title', 50);
      $table->string('thumb', 200)->nullable();
      $table->string('describe', 300);
      $table->string('url', 250);
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
    Schema::dropIfExists('webstack_sites');
  }
}
