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
        Schema::table('mnt_clinico', function (Blueprint $table) {
            $table->unsignedBigInteger('expediente_id')->nullable();
            $table->unsignedBigInteger('consulta_id')->nullable();
            $table->foreign('consulta_id')->references('id')->on('mnt_consulta');
            $table->foreign('expediente_id')->references('id')->on('mnt_expediente');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mnt_clinico', function (Blueprint $table) {
            $table->dropColumn('consulta_id');
        });
    }
};
