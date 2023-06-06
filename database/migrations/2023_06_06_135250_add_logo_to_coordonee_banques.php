<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogoToCoordoneeBanques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('coordonee_banques', function (Blueprint $table) {
        $table->string('logo')->nullable();
    });
}

public function down()
{
    Schema::table('coordonee_banques', function (Blueprint $table) {
        $table->dropColumn('logo');
    });
}

}
