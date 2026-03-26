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
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->id();
            $table->string("num_habitacion", 10)->unique();
            $table->string("imagen");
            $table->foreignId("id_tipo_habitacion")->constrained("tipos_habitacion");
            $table->foreignId("id_estado")->constrained("estados");
            $table->timestamps();
            $table->softDeletes();

            $table->index("id_tipo_habitacion");
            $table->index("id_estado");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitaciones');
    }
};
