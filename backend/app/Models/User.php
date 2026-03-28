<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */



    protected $fillable = [
        'name',
        'lastname',
        'email',
        'ci',
        'password',
        "rol_id",
        'es_admin',
        'es_empleado',
        'es_cliente',
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function rol()
    {
        return $this->belongsTo(Roles::class, "rol_id");
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function empleado()
    {
        return $this->hasOne(Empleado::class, "id_user");
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class, "id_user");
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
