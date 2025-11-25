<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoftwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("softwares", function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('slug');
            $table->string('version');
            $table->string('type')->comment('类型：soft应用,template模板,plugin插件,extension拓展');
            $table->string('changelog');
        });
        // software_packages
        // software_package_files
        // software_package_tables
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
