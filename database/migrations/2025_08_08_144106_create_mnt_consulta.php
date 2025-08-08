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
        Schema::create('mnt_consulta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expediente_id');
            $table->date('fecha_consulta');
            $table->unsignedBigInteger('tipo_consulta_id');
            $table->string('descripcion_consulta')->nullable();
            $table->foreign('expediente_id')->references('id')->on('mnt_expediente');
            $table->foreign('tipo_consulta_id')->references('id')->on('ctl_tipo_consulta');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mnt_consulta');
    }
};
