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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->string("origen_reserva");
            $table->string("codigo_promocion");
            $table->string("descuento_monto");
            $table->integer("total");
            $table->date("fecha_ini");
            $table->date("fecha_fin");

            $table->foreignId("id_recepcion")->references("id")->on("users");
            $table->foreignId("id_cliente")->references("id")->on("users");
            $table->foreignId("estado_id")->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
