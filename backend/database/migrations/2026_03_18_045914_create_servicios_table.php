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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->decimal("costo_unit", 8, 2);
            $table->foreignId("id_departamento")->constrained("departamentos")->onDelete("cascade");
            $table->timestamps();

            $table->softDeletes();
            $table->index("id_departamento");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
