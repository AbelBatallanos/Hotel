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
        Schema::create('reparacions', function (Blueprint $table) {
            $table->id();
            $table->text("detalle_averia");
            $table->integer("costo_reparacion");
            $table->datetimes("fecha_reporte");
            $table->datetimes("fecha_resolucion");
            $table->foreignId("id_habitacion")->references("id")->on("habitaciones");
            $table->foreignId("id_empleado")->references("id")->on("empleados")->default(NULL);
            $table->foreignId("id_proveedor")->references("id")->on("proveedores")->default(NULL);
            $table->foreignId("id_estado")->references("id")->on("estados");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reparacions');
    }
};
