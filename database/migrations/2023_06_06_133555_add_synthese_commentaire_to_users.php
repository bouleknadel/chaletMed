<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSyntheseCommentaireToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('synthese_commentaire')->nullable();
        });

        Schema::table('cotisations', function (Blueprint $table) {
            $table->text('commentaire')->nullable();
        });

        Schema::table('charges', function (Blueprint $table) {
            $table->text('commentaire')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('synthese_commentaire');
        });

        Schema::table('cotisations', function (Blueprint $table) {
            $table->dropColumn('commentaire');
        });

        Schema::table('charges', function (Blueprint $table) {
            $table->dropColumn('commentaire');
        });
    }
}
