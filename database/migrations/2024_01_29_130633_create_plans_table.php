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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->unsignedBigInteger("player_id")->nullable();
            $table->foreign("player_id")->references("id")->on("players")->onDelete("CASCADE");
            $table->unsignedBigInteger("match_id")->nullable();
            $table->foreign("match_id")->references("id")->on("matches")->onDelete("CASCADE");
            $table->enum('status',['main','beanch']);
            

            $table->unique(['match_id','player_id']);




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
        Schema::dropIfExists('plans');
    }
};
