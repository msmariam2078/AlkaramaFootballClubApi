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
        Schema::create('topfans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name');

            $table->unsignedBigInteger("association_id");
            $table->foreign("association_id")->references("id")->on("associations")->onDelete("CASCADE");
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
        Schema::dropIfExists('topfans');
    }
};
