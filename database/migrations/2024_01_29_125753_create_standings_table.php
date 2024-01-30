<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');

            $table->integer('win');
            $table->integer('lose');
            $table->integer('draw');
            $table->integer('+/-');
            $table->integer('points');
            $table->integer('play');
            $table->unsignedBigInteger("club_id")->nullable();
            $table->foreign("club_id")->references("id")->on("clubs")->onDelete("CASCADE");
            $table->unsignedBigInteger("session_id")->nullable();
            $table->foreign("session_id")->references("id")->on("sessions")->onDelete("CASCADE");
            $table->unique(['club_id','session_id']);
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
        Schema::dropIfExists('standings');
    }
};
