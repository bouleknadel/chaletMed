<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoordoneeBanquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordonee_banques', function (Blueprint $table) {
            $table->id();
            $table->string('numero_compte');
            $table->string('raison_sociale');
            $table->string('ville');
            $table->string('banque');
            $table->string('cle');
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
        Schema::dropIfExists('coordonee_banques');
    }
}
