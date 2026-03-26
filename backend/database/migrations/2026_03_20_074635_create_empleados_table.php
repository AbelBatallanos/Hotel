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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->dateTime("fechahora_contratacion");
            $table->decimal("sueldo", 8, 2)->default(0);
            $table->foreignId("id_user")->constrained("users")->onDelete("cascade");
            $table->foreignId("id_turno")->constrained("turnos");
            $table->text("historial_notas")->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index("id_user");
            $table->index("id_turno");
            $table->index("fechahora_contratacion");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
