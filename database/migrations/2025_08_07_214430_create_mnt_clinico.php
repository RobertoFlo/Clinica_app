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
        Schema::create('mnt_clinico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('consulta_id');
            $table->date('fecha_consulta');
            $table->decimal('total_pagar', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('paciente_id')->references('id')->on('mnt_paciente');
            $table->foreign('consulta_id')->references('id')->on('mnt_consulta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mnt_clinico');
    }
};
