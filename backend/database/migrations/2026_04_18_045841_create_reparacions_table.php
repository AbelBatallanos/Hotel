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
        Schema::create('reparaciones', function (Blueprint $table) {
            $table->id();
            $table->text("detalle_averia");
            $table->decimal("costo_reparacion", 10, 2);
            $table->dateTime("fecha_reporte");
            $table->dateTime("fecha_resolucion")->nullable();

            $table->foreignId("id_habitacion")
                ->constrained("habitaciones")
                ->onDelete("cascade")
                ->onUpdate("cascade");

            $table->foreignId("id_empleado")
                ->nullable()
                ->constrained("empleados")
                ->onDelete("set null");

            $table->foreignId("id_proveedor")
                ->nullable()
                ->constrained("proveedores")
                ->onDelete("set null");

            $table->foreignId("id_estado")
                ->constrained("estados")
                ->onDelete("cascade")
                ->onUpdate("cascade");
            $table->timestamps();

            $table->index("id_habitacion");
            $table->index("id_estado");
            $table->index("id_empleado");
            $table->index("id_proveedor");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reparaciones');
    }
};
