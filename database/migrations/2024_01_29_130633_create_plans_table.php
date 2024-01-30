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
            $table->uuid('uuid');
            $table->unsignedBigInteger("player_id")->nullable();
            $table->foreign("player_id")->references("id")->on("players")->onDelete("CASCADE");
            $table->unsignedBigInteger("matching_id")->nullable();
            $table->foreign("matching_id")->references("id")->on("matchings")->onDelete("CASCADE");
            $table->enum('status',['main','beanch']);
            

            $table->unique(['matching_id','player_id']);




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
