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
        Schema::create('replacments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("inplayer_id");
            $table->foreign("inplayer_id")->references("id")->on("players")->onDelete("CASCADE");
            $table->unsignedBigInteger("outplayer_id")->nullable();
            $table->foreign("outplayer_id")->references("id")->on("players")->onDelete("SET NULL");
            $table->unsignedBigInteger("match_id");
            $table->foreign("match_id")->references("id")->on("matches")->onDelete("CASCADE");
            $table->unique(['match_id','inplayer_id']);
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
        Schema::dropIfExists('replacments');
    }
};
