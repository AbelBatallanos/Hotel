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
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id();
            $table->date("fecha_ini")->nullable();
            $table->date("fecha_fin")->nullable();
            $table->foreignId("id_tipo_habitacion")->constrained("tipos_habitacion")->onDelete("cascade");
            $table->decimal("descuento", 10, 2)->default(0);
            $table->boolean("activo")->default(true);
            $table->timestamps();

            $table->index("fecha_ini");
            $table->index("fecha_fin");
            $table->index("id_tipo_habitacion");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifas');
    }
};
