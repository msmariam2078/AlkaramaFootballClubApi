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
        Schema::create('wears', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');

            $table->string('image');
            $table->unsignedBigInteger("session_id");
            $table->foreign("session_id")->references("id")->on("sessions")->onDelete("CASCADE");
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
        Schema::dropIfExists('wears');
    }
};
