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
        Schema::create('consumos', function (Blueprint $table) {
            $table->id();
            $table->decimal("subtotal", 10, 2);
            $table->integer("cantidad");
            $table->foreignId("id_servicio")->constrained("servicios")->onUpdate("cascade");
            $table->morphs("consumible"); //polimorfismo
            $table->dateTime("fechaHora_creacion");
            $table->timestamps();
            $table->softDeletes();

            $table->index("id_servicio");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumos');
    }
};
