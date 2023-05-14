<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatuValidationToCotisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotisations', function (Blueprint $table) {
            $table->enum('statuValidation', ['en attente', 'validé'])->default('en attente')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cotisations', function (Blueprint $table) {
            $table->dropColumn('statuValidation');
        });
    }
}
