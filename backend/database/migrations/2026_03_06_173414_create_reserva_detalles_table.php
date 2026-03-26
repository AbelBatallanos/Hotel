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
            $table->decimal("subtotal", 10, 2);
            $table->foreignId("reserva_id")->constrained("reservas")->onDelete("cascade");
            $table->foreignId("habitacion_id")->constrained("habitaciones")->onUpdate("cascade");
            $table->foreignId("estado_id")->constrained("estados");
            $table->timestamps();
            $table->softDeletes();

            $table->index("reserva_id");
            $table->index("habitacion_id");
            $table->index("estado_id");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserva_detalles');
    }
};
