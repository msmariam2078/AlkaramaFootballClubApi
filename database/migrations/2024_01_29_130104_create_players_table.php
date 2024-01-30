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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name');
            $table->integer('high');
            $table->string('play');
            $table->integer('number');
            $table->date('born');
            $table->string('from');
            $table->string('first_club');
            $table->json('career')->nullable();
            $table->string('image');
            $table->unsignedBigInteger("sport_id");
            $table->foreign("sport_id")->references("id")->on("sports")->onDelete("CASCADE");







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
        Schema::dropIfExists('players');
    }
};
