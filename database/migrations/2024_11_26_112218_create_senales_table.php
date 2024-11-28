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
        Schema::create('senales', function (Blueprint $table) {
            $table->id();
            $table->string('cliente'); // Nombre del cliente
            $table->integer('envios'); // Cantidad de envíos
            $table->date('dia'); // Día del envío
            $table->time('hora'); // Hora del envío
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('senales');
    }
};