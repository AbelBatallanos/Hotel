<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habitaciones extends Model
{
    use SoftDeletes;
<<<<<<< HEAD
    protected $fillable = [
        "id_tipo_habitacion",
        "num_habitacion",
        "id_estado",
        "imagen",
        "descripcion"
    ];
=======
    protected $table = 'habitaciones';
    protected $fillable = ["id_tipo_habitacion", "num_habitacion", "id_estado", "imagen", "descripcion"];
>>>>>>> 0dcead6 (Implementacion de services correspondiente a las entidades, implementacion de scopes, mutadores y accessors en los modelos)

    /*  Relaciones  */
    public function estado()
    {
        return $this->belongsTo(Estados::class, "id_estado");
    }
    public function tipohabitacion()
    {
        return $this->belongsTo(TiposHabitacion::class, "id_tipo_habitacion");
    }
    public function reservadetalles(){
        return $this->hasMany(ReservaDetalle::class, "habitacion_id");
    }

    public function reservas()
    {
        return $this->hasManyThrough(
            Reserva::class,        // Modelo final
            ReservaDetalle::class, // Modelo intermedio
            'habitacion_id',       // FK en ReservaDetalle que apunta a Habitacion
            'id',                  // FK en Reserva que apunta a ReservaDetalle
            'id',                  // PK local en Habitacion
            'reserva_id'           // FK en ReservaDetalle que apunta a Reserva
        );
    }

    /* Scope reutilizables */

    public function scopeExistsHabitacion($query, $id){
        return $query->find($id)->exists();
    }

    public function scopeMultiplesHabitaciones($query, array $habIds){
        return $query->whereIn("id", $habIds);
    }
    public function scopeUpdateFields($query, array $fields){
        return $query->update($fields);
    }

    public function scopeDisponibles($query){
        return $query->where("id_estado", 1);
    }

    public function scopeConDetalles($query){
        return $query->with(["estado","tipohabitacion"]);
    }

    /*Trae solo los registros eliminados */
    public function scopeEliminados($query){
        return $query->onlyTrashed();
    }

    public function scopeConEstado($query, $estadoNombre){
        return $query->whereHas("estado", function($q)use($estadoNombre){
            $q->where("nombre", $estadoNombre);
        });
    }

    public function scopeDisponiblesEnFecha($query, $fechaIni, $fechaFin){
        
        return $query->whereDoesntHave("reservas", function($q)use($fechaIni,$fechaFin){
            $q->where("fecha_ini","<",$fechaFin) 
              ->where("fecha_fin",">",$fechaIni);
        });
    }



    /*Mutadores*/
    public function setNumHabitacionAttribute($value){
        $this->attributes["num_habitacion"] = strtoupper($value);
    }


    /* Accessors */
    public function getDescripcionAttribute(){
        return $this->num_habitacion . "--" . $this->estado->nombre;
    }

    public function getDisponibleAttribute()
    {
        return $this->estado->nombre === 'Disponible';
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }


}
