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
        Schema::create('conductores', function (Blueprint $table) {
            $table->id();
            $table->boolean('es_propietario')->nullable(false)->default(false);
            $table->string('nro_cedula', 20)->unique()->nullable(false);
            $table->string('primer_nombre', 50)->nullable(false);
            $table->string('segundo_nombre', 50)->nullable(true);
            $table->string('apellidos', 100)->nullable(false);
            $table->string('telefono', 20)->nullable(false);
            $table->string('direccion', 150)->nullable(false);
            $table->string('ciudad', 50)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conductores');
    }
};
