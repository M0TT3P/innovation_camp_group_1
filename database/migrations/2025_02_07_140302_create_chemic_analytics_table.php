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
        Schema::create('chemic_analytics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('see_id');
            $table->date('datum');
            $table->string('wetter')->nullable();
            $table->string('sonderzustand')->nullable();
            $table->float('temperatur')->nullable();
            $table->float('sauerstoffgehalt')->nullable();
            $table->float('ph')->nullable();
            $table->float('el')->nullable();
            $table->float('ung_stoffe')->nullable();
            $table->float('ammonium')->nullable();
            $table->float('nitrit')->nullable();
            $table->float('nitrat')->nullable();
            $table->float('ortho_p')->nullable();
            $table->float('gesamt_p')->nullable();
            $table->float('np_verhaltnis')->nullable(); // N/P-Verhältnis
            $table->float('doc')->nullable();
            $table->float('chlorid')->nullable();
            $table->float('chlorophyll')->nullable();

            // Falls du eine Relation zu einer 'sees'- oder 'seen'-Tabelle hast:
            $table->foreign('see_id')->references('id')->on('seen');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chemic_analytics');
    }
};
