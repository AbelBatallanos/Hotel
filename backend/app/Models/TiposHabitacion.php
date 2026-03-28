<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TiposHabitacion extends Model
{
    use SoftDeletes;
    protected $table = 'tipos_habitacion';
    protected $fillable = ["nombre", "precio_base", "amenities", "tipo_cama", "capacidad"];


    public function habitaciones()
    {
        return $this->hasMany(Habitaciones::class);
    }

    public function tarifa()
    {
        return $this->hasOne(Tarifa::class, "id_tipo_habitacion");
    }

    public function calcularSubtotal($fecha)
    {
        $tarifa = $this->tarifa()->TarifaDescuento($fecha, $this->id);
        return max(0, $this->precio_base - ($tarifa->descuento ?? 0));
    }
}
