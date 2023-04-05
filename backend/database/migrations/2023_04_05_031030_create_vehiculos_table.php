<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('placa', 50)->unique()->nullable(false);
            $table->string('motor', 256)->nullable(true);
            $table->string('marca', 50)->nullable(false);
            $table->string('color', 50)->nullable(true);
            $table->tinyInteger('tipo_vehiculo')->nullable(false);
            $table->unsignedBigInteger('id_conductor');
            $table->timestamps();
            $table->foreign('id_conductor')->references('id')->on('conductores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
