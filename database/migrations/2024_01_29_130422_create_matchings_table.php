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
        Schema::create('matchings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->datetime("when");
            $table->enum('status',['not_started','finished','live']);
            $table->string('plan_image');
            $table->string('channel');
            $table->string('round')->unique();
            $table->string('play_ground');
            $table->unsignedBigInteger("session_id");
            $table->foreign("session_id")->references("id")->on("sessions")->onDelete("CASCADE");
            $table->unsignedBigInteger("club1_id");
            $table->foreign("club1_id")->references("id")->on("clubs")->onDelete("CASCADE");
            $table->unsignedBigInteger("club2_id");
            $table->foreign("club2_id")->references("id")->on("clubs")->onDelete("CASCADE");
         
            $table->unique(['club1_id','club2_id','session_id']);
            
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
        Schema::dropIfExists('matchings');
    }
};
