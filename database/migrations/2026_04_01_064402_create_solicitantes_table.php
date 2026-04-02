<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('solicitantes', function (Blueprint $table) {
            $table->id();
            
            $table->string('nome', 100);
            $table->string('nif_cif', 9)->unique();
            $table->string('email', 150)->unique();
            $table->string('telefono', 15);
            
            $table->string('direccion', 200);
            $table->string('cidade', 100);
            $table->string('provincia', 100);
            $table->string('codigo_postal', 5);
            $table->string('pais');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitantes');
    }
};
