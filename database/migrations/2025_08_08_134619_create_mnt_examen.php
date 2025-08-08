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
        Schema::create('mnt_examen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinico_id');
            $table->unsignedBigInteger('tipo_examen_id');
            $table->string('observacion')->nullable();
            $table->timestamps();
            $table->foreign('clinico_id')->references('id')->on('mnt_clinico');
            $table->foreign('tipo_examen_id')->references('id')->on('ctl_tipo_examen');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mnt_examen');
    }
};
