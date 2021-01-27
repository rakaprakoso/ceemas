<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCeemasTypePost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ceemas_posts', function (Blueprint $table) {
            $table->boolean('isPage')->nullable()->default(false);
            $table->boolean('isCustom')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ceemas_posts', function (Blueprint $table) {
            $table->dropColumn('isPage');
            $table->dropColumn('isCustom');
        });
    }
}
