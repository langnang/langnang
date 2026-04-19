<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends \App\Illuminate\Database\Migrations\Migration
{
    protected $prefix = "";
    protected $tableName = "_logs";
    protected $status = "private";
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
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->string('instance')->index();
            $table->string('channel')->index();
            $table->string('level')->index();
            $table->string('level_name');
            $table->longText('message');
            $table->longText('context');

            $table->integer('remote_addr')->nullable()->unsigned();
            $table->string('user_agent')->nullable();
            $table->integer('created_by')->nullable()->index();

            $table->dateTime('created_at');
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
    }
}
