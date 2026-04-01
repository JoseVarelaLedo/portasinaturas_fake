<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            //$table->bigIncrements('cod_solicitude');
            $table->unsignedBigInteger('id_entidade');
            $table->unsignedBigInteger('id_solicitante');
            $table->string('nome_entidade');
            $table->string('nome_solicitante');
            $table->boolean('enviado_sede')->nullable();
            $table->float('contia_reservada_c7')->nullable();
            $table->float('contia_reservada_c8')->nullable();
            $table->float('contia_reservada_c31')->nullable();
            $table->boolean('lista_espera')->nullable();
            $table->string('estado_doc')->nullable();
            $table->unsignedBigInteger('id_usuario_admin')->nullable();
            $table->unsignedBigInteger('id_usuario_tecnico')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
