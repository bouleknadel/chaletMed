<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleveBnksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('releve_bkns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cotisation_id');
            $table->unsignedBigInteger('user_id');
            $table->text('content');
            $table->boolean('read')->default(false);
            $table->timestamps();

            // Clés étrangères
            $table->foreign('cotisation_id')->references('id')->on('cotisations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Index
            $table->index('cotisation_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_msjs');
    }
}
