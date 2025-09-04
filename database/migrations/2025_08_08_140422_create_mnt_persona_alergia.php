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
        Schema::create('mnt_persona_alergia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('alergia_id');
            // $table->unsignedBigInteger('nvl_alergia_id');
            $table->foreign('paciente_id')->references('id')->on('mnt_paciente');
            $table->foreign('alergia_id')->references('id')->on('ctl_alergia');
            // $table->foreign('nvl_alergia_id')->references('id')->on('ctl_nvl_alergia');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mnt_persona_alergia');
    }
};
