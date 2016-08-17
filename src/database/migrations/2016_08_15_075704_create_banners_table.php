<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bannerplaces', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        Schema::create('banners', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('bannerplace_id')->unsigned()->nullable()->default(0);
            $table->integer('position');
            $table->integer('all_pages')->nullable()->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('banner_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('banner_id')->unsigned();
            $table->string('locale');
            $table->boolean('status')->default(0);
            $table->string('title');
            $table->string('link');
            $table->text('summary');
            $table->text('body');
            $table->timestamps();
            $table->unique(['banner_id', 'locale']);
            $table->foreign('banner_id')->references('id')->on('banners')->onDelete('cascade');

        });

        Schema::create('banner_page', function (Blueprint $table) {
            $table->integer('banner_id');
            $table->integer('page_id');
            $table->unique(['banner_id', 'page_id']);
            $table->foreign('banner_id')->references('id')->on('banners')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->integer('position')->unsigned();
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
        Schema::drop('banner_page');
        Schema::drop('banner_translations');
        Schema::drop('banners');
        Schema::drop('bannerplace_translations');
        Schema::drop('bannerplaces');
    }
}
