<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Invocamos los seeders individuales en orden jerárquico
        $this->call([
            RolesSeeder::class,
            EstadosSeeder::class,
            TiposHabitacionSeeder::class,
            // Agregamos un usuario administrador por defecto para pruebas

        ]);
    }
}
