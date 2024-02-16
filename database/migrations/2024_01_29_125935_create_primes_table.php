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
        Schema::create('primes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('desc')->nullable();
            $table->string('name');
         
        
            $table->string('image');
            $table->enum('type',['personal','club']);
            $table->unsignedBigInteger("session_id");
            $table->foreign("session_id")->references("id")->on("sessions")->onDelete("NO ACTION")->nullable();
            $table->unsignedBigInteger("sport_id");
            $table->foreign("sport_id")->references("id")->on("sports")->onDelete("CASCADE");
            $table->unique(['name','session_id']);
            



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
        Schema::dropIfExists('primes');
    }
};
