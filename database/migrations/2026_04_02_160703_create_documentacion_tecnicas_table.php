<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentaciones_tecnicas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('solicitude_id')
                ->unique()
                ->constrained('solicitudes')
                ->cascadeOnDelete();

            $table->string('estado_memoria_tecnica')->nullable();
            $table->string('estado_presupuesto')->nullable();
            $table->string('estado_ofertas_proveedores')->nullable();
            $table->string('estado_planos')->nullable();
            $table->string('estado_estudio_energetico')->nullable();
            $table->string('estado_fichas_tecnicas')->nullable();
            $table->string('estado_licencias')->nullable();
            $table->string('estado_cronograma')->nullable();

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('documentaciones_tecnicas');
    }
};
