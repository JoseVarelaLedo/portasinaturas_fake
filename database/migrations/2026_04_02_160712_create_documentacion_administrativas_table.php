<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('documentaciones_administrativas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('solicitude_id')
              ->unique()
              ->constrained('solicitudes')
              ->cascadeOnDelete();
       
        $table->string('estado_formulario_solicitud')->nullable();
        $table->string('estado_documento_identificativo')->nullable();
        $table->string('estado_acreditacion_representacion')->nullable();
        $table->string('estado_certificado_aeat')->nullable();
        $table->string('estado_certificado_seguridad_social')->nullable();
        $table->string('estado_declaracion_responsable')->nullable();
        $table->string('estado_datos_bancarios')->nullable();
        $table->string('estado_escritura_constitucion')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentaciones_administrativas');
    }
};
