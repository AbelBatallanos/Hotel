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
        Schema::create('reserva_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer("subtotal");
            $table->foreignId("reserva_id")->references("id")->on("reservas")->onDelete("cascade");
            $table->foreignId("habitacion_id")->constrained("habitaciones");
            $table->foreignId("estado_id")->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva_detalles');
    }
};
