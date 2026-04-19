<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAdminContentsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(" DROP VIEW IF EXISTS admin_contents");
        DB::statement(" CREATE VIEW admin_contents AS SELECT * FROM  " . with(new \App\Models\Content())->getTable());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement(" DROP VIEW IF EXISTS admin_contents");
    }
}
