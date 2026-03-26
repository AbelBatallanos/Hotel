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
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_habitacion")
                ->constrained("habitaciones")
                ->onDelete("cascade")
                ->onUpdate("cascade");

            $table->foreignId("id_user")
                ->constrained("users")
                ->onDelete("cascade")
                ->onUpdate("cascade");


            $table->timestamps();
            $table->softDeletes();

            $table->index("id_habitacion");
            $table->index("id_user");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoritos');
    }
};
