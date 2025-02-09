<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('monitoring', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('see_id');
            $table->date('datum');
            $table->float('pegelstand')->nullable();
            $table->float('verdunstung')->nullable();
            $table->float('niederschlag')->nullable();
            $table->float('temperatur')->nullable();

            // Optional: falls es eine Fremdschlüsselbeziehung zu 'seen' oder 'sees' gibt
            $table->foreign('see_id')->references('id')->on('seen')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring');
    }
};
