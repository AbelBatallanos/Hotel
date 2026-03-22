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
            $table->foreignId("id_empleado")->constrained("empleados");
            $table->foreignId("id_estado")->constrained("estados");
            $table->timestamps();
            $table->softDeletes();

            $table->index(["fecha_creada", "fecha_limite"]);
            $table->index("id_empleado");
            $table->index("id_estado");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
