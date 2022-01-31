<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandeAccompagnementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commande_accompagnement', function (Blueprint $table) {
            $table->bigInteger('commande_id')->unsigned();
            $table->foreign('commande_id')->references('id')->on('commandes')->onDelete('cascade');
            $table->bigInteger('accompagnement_id')->unsigned();
            $table->foreign('accompagnement_id')->references('id')->on('accompagnements')->onDelete('cascade');
            $table->primary(['commande_id', 'accompagnement_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commande_accompagnement');
    }
}
