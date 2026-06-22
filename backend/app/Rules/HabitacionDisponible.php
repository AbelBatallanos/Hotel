<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\PotentiallyTranslatedString;

class HabitacionDisponible implements ValidationRule
{

    protected $fecha_ini;
    protected $fecha_fin;

    public function __construct($fecha_ini, $fecha_fin)
    {
        $this->fecha_ini = $fecha_ini;
        $this->fecha_fin = $fecha_fin;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
        $ocupado = DB::table("reserva_detalles")
            ->join("reservas", "reserva_detalles.reserva_id", "=", "reservas.id")
            ->where("reserva_detalles.habitacion_id", $value)
            ->where(function($query){
                $query->where("reservas.fecha_ini","<", $this->fecha_fin)
                ->where("reservas.fecha_fin",">",$this->fecha_ini);  
            })->exists();

        if ($ocupado) {
            // Buscamos el número de habitación para dar un mensaje de error más amigable
            $habitacion = DB::table('habitaciones')->where('id', $value)->first();
            $num_hab = $habitacion ? $habitacion->num_habitacion : $value;

            // Disparamos el error
            $fail("La habitación #{$num_hab} ya se encuentra reservada en las fechas seleccionadas.");
        }
    }
}
