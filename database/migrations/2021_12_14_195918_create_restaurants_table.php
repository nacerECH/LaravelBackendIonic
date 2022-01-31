<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nom');
            $table->string('description');
            $table->string('adresse');
            $table->string('ville');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('offre')->nullable();
            $table->string('photo')->nullable();
            $table->string('video')->nullable();
            $table->string('NomGerant')->nullable();
            $table->string('tel')->nullable();
            $table->string('PageFacebook')->nullable();
            $table->string('PageInstagram')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('restaurants');
    }
}
