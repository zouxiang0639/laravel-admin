<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_nav', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0)->comment('父级ID');
            $table->integer('template_id')->comment('模版id');
            $table->tinyInteger('is_template')->comment('是否使用模版 WhetherConst');
            $table->integer('order')->default(0)->comment('排序');
            $table->string('title', 255)->comment('标题');
            $table->tinyInteger('type')->comment('类型 NavTypeConst');

            $table->string('url', 255)->default('')->comment('网站地址');
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_nav` comment '客户端导航'");

        Schema::create('admin_page', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->default('')->comment('标题');
            $table->tinyInteger('template')->default(0)->comment('模版 PageTemplateConst');
            $table->text('picture')->string('comment', 255)->default('')->comment('缩率图');
            $table->string('comment', 255)->default('')->comment('描述');
            $table->text('contents')->nullable()->comment('内容');
            $table->text('extend')->nullable()->comment('扩展');
            $table->string('keywords', 255)->default('')->comment('关键字');
            $table->string('description', 255)->default('')->comment('描述');
            $table->timestamp('deleted_at')->default(0);
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_page` comment '客户端页面'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_nav');
        Schema::dropIfExists('admin_page');
    }
}
