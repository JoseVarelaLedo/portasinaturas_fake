<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_solicitude');
            $table->unsignedInteger('id_solicitante');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emendas');
    }
};
