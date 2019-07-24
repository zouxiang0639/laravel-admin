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
            $table->tinyInteger('bind_type')->comment('绑定类型 NavBindTypeConst');
            $table->tinyInteger('category')->comment('类别 NavCategoryConst');
            $table->integer('page_id')->comment('绑定页面');
            $table->string('url', 255)->comment('网站地址');
            $table->integer('order')->default(0)->comment('排序');
            $table->string('title', 255)->comment('标题');
            $table->string('alias', 255)->comment('别名');
            $table->tinyInteger('type')->comment('类型 NavTypeConst');
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


        Schema::create('admin_news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->default('')->comment('标题');
            $table->integer('page_id')->default(0)->comment('页面ID');
            $table->text('picture')->string('comment', 255)->default('')->comment('缩率图');
            $table->string('comment', 255)->default('')->comment('描述');
            $table->text('contents')->nullable()->comment('内容');
            $table->string('keywords', 255)->default('')->comment('关键字');
            $table->string('description', 255)->default('')->comment('描述');
            $table->tinyInteger('status')->comment('状态 1启用 2禁用 :WhetherConst');
            $table->timestamp('deleted_at')->default(0);
            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `admin_news` comment '客户端信息列表详情'");


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
        Schema::dropIfExists('admin_news');
    }
}
