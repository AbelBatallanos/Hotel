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
            $table->string("origen_reserva", 25);
            $table->string("codigo_promocion", 30)->nullable();
            $table->decimal("descuento_monto", 10, 2)->default(0);
            $table->decimal("total", 10, 2);
            $table->date("fecha_ini");
            $table->date("fecha_fin");

            $table->foreignId("id_recepcion")
                ->nullable()
                ->constrained("users")
                ->onDelete("set null");

            $table->foreignId("id_cliente")
                ->constrained("users")
                ->onDelete("cascade");

            $table->foreignId("estado_id")->constrained()->onDelete("cascade");
            $table->timestamps();
            $table->softDeletes();

            $table->index(["fecha_ini", "fecha_fin"]);
            $table->index("id_recepcion");
            $table->index("id_cliente");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
