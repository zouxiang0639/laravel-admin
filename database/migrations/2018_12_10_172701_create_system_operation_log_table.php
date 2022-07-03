<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemOperationLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_system_operation_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_no')->default(0)->comment('业务编号');
            $table->integer('operator')->default(0)->comment('操作人');
            $table->string('url', 255)->comment('操作url');
            $table->string('ip', 255)->comment('操作人IP');
            $table->string('function_block', 255)->comment('功能版块');
            $table->string('action', 255)->comment('操作类型');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_system_operation_log` comment '系统操作日志'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_system_operation_log');
    }
}
