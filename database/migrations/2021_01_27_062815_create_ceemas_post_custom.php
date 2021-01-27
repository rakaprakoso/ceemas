<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCeemasPostCustom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ceemas_post_custom', function (Blueprint $table) {
            $table->id();
            $table->biginteger('post_id')->unsigned()->nullable();
            $table->foreign('post_id')->references('id')->on('ceemas_posts')->onDelete('cascade');
            $table->string('view')->nullable();
            $table->string('controller')->nullable();
            $table->string('function_controller')->nullable();
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
        Schema::dropIfExists('ceemas_post_custom');
    }
}
