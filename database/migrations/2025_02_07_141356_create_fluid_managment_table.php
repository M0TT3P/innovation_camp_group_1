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
        Schema::create('fluid_managment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('see_id');
            $table->string('type')->nullable();
            $table->string('comming_from')->nullable();
            $table->string('going_too')->nullable();
            $table->string('reason')->nullable();
            $table->string('started_drain')->nullable();
            $table->string('ended_drain')->nullable();
            $table->float('menge')->nullable();
            $table->date('datum');
            $table->float('pegelstand_vor')->nullable();
            $table->float('pegelstand_nach')->nullable();

            // Optional: Wenn eine Fremdschlüsselbeziehung zu einer 'seen'- oder 'sees'-Tabelle existiert:
            $table->foreign('see_id')->references('id')->on('seen')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fluid_managment');
    }
};
