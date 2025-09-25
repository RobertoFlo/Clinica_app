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
        // Tablas sin dependencias primero
        Schema::create('ctl_estado', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });
        Schema::create('ctl_categoria_alergia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('ctl_tipo_examen', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->decimal('precio', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('ctl_tipo_consulta', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->decimal('precio', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('mnt_paciente', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('apellido', 150);
            $table->string('telefono', 9)->nullable();
            $table->string('direccion', 250)->nullable();
            $table->string('documento_identidad', 10)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo', ['M', 'F'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        // Tablas con dependencias
        Schema::create('ctl_alergia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('ctl_categoria_alergia');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('mnt_expediente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->date('fecha_creacion');
            $table->string('numero_expediente')->unique();
            $table->foreign('paciente_id')->references('id')->on('mnt_paciente');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('mnt_medicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('especialidad');
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('mnt_clinico', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_consulta');
            $table->unsignedBigInteger('expediente_id')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->foreign('estado_id')->references('id')->on('ctl_estado');
            $table->foreign('expediente_id')->references('id')->on('mnt_expediente');
            $table->decimal('total_pagar', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('mnt_cita', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expediente_id')->nullable();
            $table->date('fecha_cita');
            $table->time('hora_cita');
            $table->string('nombre_paciente')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->foreign('estado_id')->references('id')->on('ctl_estado');
            $table->foreign('expediente_id')->references('id')->on('mnt_expediente');
            $table->unsignedBigInteger('medico_id')->nullable();
            $table->foreign('medico_id')->references('id')->on('mnt_medicos');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('mnt_consulta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expediente_id')->nullable();
            $table->unsignedBigInteger('cita_id')->nullable();
            $table->unsignedBigInteger('clinico_id')->nullable();
            $table->date('fecha_consulta');
            $table->unsignedBigInteger('tipo_consulta_id');
            $table->string('descripcion_consulta')->nullable();
            $table->unsignedBigInteger('medico_id')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->decimal('subtotal_final', 10, 2)->nullable();
            $table->foreign('estado_id')->references('id')->on('ctl_estado');
            $table->foreign('medico_id')->references('id')->on('mnt_medicos');
            $table->foreign('cita_id')->references('id')->on('mnt_cita');
            $table->foreign('clinico_id')->references('id')->on('mnt_clinico');
            $table->foreign('expediente_id')->references('id')->on('mnt_expediente');
            $table->foreign('tipo_consulta_id')->references('id')->on('ctl_tipo_consulta');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('mnt_examen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinico_id');
            $table->unsignedBigInteger('tipo_examen_id');
            $table->string('url_documento')->nullable();
            $table->string('observacion')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->foreign('estado_id')->references('id')->on('ctl_estado');
            $table->foreign('clinico_id')->references('id')->on('mnt_clinico');
            $table->foreign('tipo_examen_id')->references('id')->on('ctl_tipo_examen');
            $table->softDeletes();
        });
        Schema::create('mnt_persona_alergia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('alergia_id');
            $table->foreign('paciente_id')->references('id')->on('mnt_paciente');
            $table->foreign('alergia_id')->references('id')->on('ctl_alergia');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('mnt_receta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consulta_id');
            $table->date('fecha_receta');
            $table->text('indicaciones')->nullable();
            $table->foreign('consulta_id')->references('id')->on('mnt_consulta');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
    // Eliminar primero las tablas hijas (dependientes)
    Schema::dropIfExists('mnt_receta');
    Schema::dropIfExists('mnt_persona_alergia');
    Schema::dropIfExists('mnt_examen');
    Schema::dropIfExists('mnt_consulta');
    Schema::dropIfExists('mnt_cita');
    Schema::dropIfExists('mnt_clinico');
    Schema::dropIfExists('mnt_expediente');
    Schema::dropIfExists('mnt_medicos');
    Schema::dropIfExists('ctl_alergia');
    Schema::dropIfExists('mnt_paciente');
    Schema::dropIfExists('ctl_tipo_consulta');
    Schema::dropIfExists('ctl_tipo_examen');
    Schema::dropIfExists('ctl_categoria_alergia');
    Schema::dropIfExists('ctl_estado');
    }
};