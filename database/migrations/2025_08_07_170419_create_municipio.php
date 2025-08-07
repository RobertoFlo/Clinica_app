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
        //
        Schema::create('ctl_municipio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', length: 100);
            $table->unsignedBigInteger('departamento_id');
            $table->foreign('departamento_id')->references('id')->on('ctl_departamento');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        schema::drop('ctl_municipio');
    }
};
