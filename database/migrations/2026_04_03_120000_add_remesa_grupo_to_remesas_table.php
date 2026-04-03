<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('remesas', function (Blueprint $table) {
            $table->string('remesa_grupo', 50)->nullable()->after('id');
            $table->index('remesa_grupo');
        });
    }

    public function down(): void
    {
        Schema::table('remesas', function (Blueprint $table) {
            $table->dropIndex(['remesa_grupo']);
            $table->dropColumn('remesa_grupo');
        });
    }
};
