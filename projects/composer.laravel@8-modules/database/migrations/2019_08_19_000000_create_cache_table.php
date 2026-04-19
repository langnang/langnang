<?php

use App\Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCacheTable extends \App\Illuminate\Database\Migrations\Migration
{
    protected $prefix = '';
    protected $tableName = 'cache';
    protected $status = "protected";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!$tableName = $this->getTableName())
            return;
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->mediumText('value');
            $table->integer('expiration');
        });
        Schema::create($tableName . '_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!$tableName = $this->getTableName())
            return;
        Schema::dropIfExists($tableName);
        Schema::dropIfExists($tableName . '_locks');
    }
}
