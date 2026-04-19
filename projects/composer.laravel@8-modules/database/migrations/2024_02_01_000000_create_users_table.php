<?php

use App\Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends \App\Illuminate\Database\Migrations\Migration
{

    protected $tableName = "_users";
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
            $table->string('slug')->unique()->nullable()->comment("标识");
            $table->string('ico')->nullable()->comment("徽标");

            $table->string('name')->nullable()->comment("名称");

            $table->string("roles")->nullable()->comment("角色");
            $table->string("permissions")->nullable()->comment("权限");

            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken()->nullable();
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
        if (!$tableName = $this->getTableName())
            return;
        Schema::dropIfExists($tableName);
    }
}
