<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sid',60)->index('sid');
            $table->string('image',200)->nullable();
            $table->string('attitude',200)->nullable();
            $table->string('friend_name',200)->nullable();
            $table->string('self_name',200)->nullable();
            $table->dateTime('created_time')->index('created_time');
            $table->string('created_ip',120)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('photos');
    }
}
