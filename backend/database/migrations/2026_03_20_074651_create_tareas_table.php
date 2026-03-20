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
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->text("descripcion");
            $table->dateTime("fecha_creada");
            $table->dateTime("fecha_limite");
            $table->foreignId("id_empleado")->references("id")->on("empleados");
            $table->foreignId("id_estado")->references("id")->on("estados");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
