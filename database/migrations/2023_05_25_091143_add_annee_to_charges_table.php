<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnneeToChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     public function up()
     {
         Schema::table('charges', function (Blueprint $table) {
             $table->integer('annee')->after('date')->nullable();
         });
     }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('charges', function (Blueprint $table) {
        $table->dropColumn('annee');
    });
}

}
