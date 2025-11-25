<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 用户信息
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name')->comment("名称");
            $table->string('slug')->comment('标识');
            $table->string('email')->unique()->comment("邮箱");
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment("密码");
            $table->rememberToken();
            $table->string('evaluation')->comment('自我评价');
            $table->timestamps();
        });
        // 教育背景
        Schema::create('user_educations', function (Blueprint $table) {
            $table->uuid('id');
        });
        // 技能掌握
        Schema::create('user_skills', function (Blueprint $table) {
            $table->uuid('id');
        });
        // 工作经历
        Schema::create('user_works', function (Blueprint $table) {
            $table->uuid('id');
        });
        // 项目经验
        Schema::create('user_projects', function (Blueprint $table) {
            $table->uuid('id');
        });
        // 获奖证书
        Schema::create('user_certificates', function (Blueprint $table) {
            $table->uuid('id');
        });
        // 关联账号
        Schema::create('user_accounts', function (Blueprint $table) {
            $table->uuid('id');
        });
        // 操作日志
        Schema::create('user_logs', function (Blueprint $table) {
            $table->uuid('id');
        });
        Schema::create('user_metas', function (Blueprint $table) {
            $table->uuid('id');
        });
        Schema::create('user_relationships', function (Blueprint $table) {
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_educations');
        Schema::dropIfExists('user_skills');
        Schema::dropIfExists('user_works');
        Schema::dropIfExists('user_projects');
        Schema::dropIfExists('user_certificates');
        Schema::dropIfExists('user_accounts');
        Schema::dropIfExists('user_logs');
    }
}
