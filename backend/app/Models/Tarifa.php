<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarifa extends Model
{
    use SoftDeletes;
    protected $filltable = ["fecha_ini", "fecha_fin", "id_tipo_habitacion", "precio", "activo"];

    protected $casts = [
        'fecha_ini' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
    ];

    public function tipohabitacion()
    {
        return $this->belongsTo(TiposHabitacion::class, "id_tipo_habitacion");
    }

    // Scope para tarifas vigentes (activas y con fecha que incluye hoy)
    public function scopeVigentes($query, $fecha = null)
    {
        $fecha = $fecha ? Carbon::parse($fecha) : Carbon::now();
        return $query->where('activo', true)
            ->where('fecha_ini', '<=', $fecha)
            ->where('fecha_fin', '>=', $fecha);
    }

    // Scope para tarifas expiradas
    public function scopeExpiradas($query, $fecha = null)
    {
        $fecha = $fecha ? Carbon::parse($fecha) : Carbon::now();
        return $query->where('fecha_fin', '<', $fecha);
    }
}
