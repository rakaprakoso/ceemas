<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCeemasPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ceemas_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('author_id')->nullable();
            $table->string('url')->nullable();
            $table->text('content')->nullable();
            $table->string('thumbnail_img')->nullable();
            $table->string('template')->nullable();
            $table->boolean('publish')->nullable()->default(false);
            $table->dateTime('published_at')->nullable();
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
        Schema::dropIfExists('ceemas_posts');
    }
}
