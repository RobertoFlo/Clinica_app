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
        Schema::create('ctl_distrito', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', length: 100);
            $table->unsignedBigInteger('municipio_id');
            $table->foreign('municipio_id')->references('id')->on('ctl_municipio');
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
        schema::drop('ctl_distrito');
    }
};
