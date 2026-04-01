<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('remesas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_emenda');
            $table->unsignedBigInteger('id_usuario_admin');
            $table->unsignedBigInteger('id_usuario_tecnico');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remesas');
    }
};
