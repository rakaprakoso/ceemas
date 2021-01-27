<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCeemasPostPostCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ceemas_post_post_category', function (Blueprint $table) {
            $table->biginteger('post_id')->unsigned()->nullable();
            $table->foreign('post_id')->references('id')->on('ceemas_posts')->onDelete('cascade');
            $table->biginteger('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('ceemas_post_categories')->onDelete('cascade');
            $table->unique(['post_id','category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ceemas_post_post_category');
    }
}
