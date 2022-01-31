<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatsAccompagnementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plats_accompagnements', function (Blueprint $table) {
            $table->bigInteger('plat_id')->unsigned();
            $table->foreign('plat_id')->references('id')->on('plats')->onDelete('cascade');
            $table->bigInteger('accompagnement_id')->unsigned();
            $table->foreign('accompagnement_id')->references('id')->on('accompagnements')->onDelete('cascade');
            $table->primary(['plat_id', 'accompagnement_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plats_accompagnements');
    }
}
