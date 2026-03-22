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
            $table->date("fecha_ini");
            $table->date("fecha_fin");
            $table->foreignId("id_tipo_habitacion")->constrained()->onDelete("cascade");
            $table->decimal("precio", 10, 2);
            $table->timestamps();

            $table->index("fecha_ini");
            $table->index("fecha_fin");
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
