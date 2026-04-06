<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documentaciones_tecnicas', function (Blueprint $table) {
            $table->json('motivos_emenda')->nullable()->after('estado_cronograma');
        });

        Schema::table('documentaciones_administrativas', function (Blueprint $table) {
            $table->json('motivos_emenda')->nullable()->after('estado_escritura_constitucion');
        });
    }

    public function down(): void
    {
        Schema::table('documentaciones_tecnicas', function (Blueprint $table) {
            $table->dropColumn('motivos_emenda');
        });

        Schema::table('documentaciones_administrativas', function (Blueprint $table) {
            $table->dropColumn('motivos_emenda');
        });
    }
};
