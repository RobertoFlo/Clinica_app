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
        // Usamos Schema::table para modificar una tabla existente
        Schema::table('mnt_clinico', function (Blueprint $table) {
            $table->unsignedBigInteger('consulta_id');
            $table->foreign('consulta_id')->references('id')->on('mnt_consulta');
           // $table->enum('estado', ['Pendiente', 'Finalizado', 'Cancelado'])->default('Pendiente')->after('total_pagar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // En el método down, revertimos el cambio eliminando la columna
        Schema::table('mnt_clinico', function (Blueprint $table) {
            $table->dropColumn('consulta_id');
        });
    }
};
