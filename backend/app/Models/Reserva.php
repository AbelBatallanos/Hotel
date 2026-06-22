<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use SoftDeletes;

    protected $fillable = ["origen_reserva", "total", "fecha_ini", "fecha_fin", "id_recepcion", "id_cliente", "estado_id"];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, "id_cliente");
    }
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, "id_recepcion");
    }
    public function userCliente(){
        return $this->belongsTo(User::class, "id_cliente");
    }
    public function userRecepcion(){
        return $this->belongsTo(User::class, "id_recepcion");
    }
    public function estado()
    {
        return $this->belongsTo(Estados::class, "estado_id");
    }

    public function detalles()
    {
        return $this->hasMany(ReservaDetalle::class, "reserva_id");
    }

    public function consumos()
    {
        return $this->morphMany(Consumo::class, "consumible");
    }


    /* Scopes */

    public function scopePendientes($query){
        return $query->where("estado_id", 5);
    }

    public function scopeDetallesPendientes($query){
        return $query->with(["cliente", "empleado", "detalles.habitacion.tipohabitacion", "detalles.estado"]);
    }

    public function scopeOcupados($query){
        return $query->where("estado_id", 2);
    }
    public function scopeDetallesOcupados($query){
        return $query->with(["cliente", "empleado", "detalles.habitacion.tipohabitacion", "detalles.estado"]);
    }
    public function scopeReservaCliente($query, $idCliente){
        return $query->where("id_cliente", $idCliente);
    }

}
