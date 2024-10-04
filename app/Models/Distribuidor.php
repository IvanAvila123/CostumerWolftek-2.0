<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribuidor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'user_id',
        'distribuidor_id',
    ];

    // ...

    public function lineas()
    {
        return $this->hasMany(Linea::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }


    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'ejecutivo');
    }

    public function oportunidad()
    {
        return $this->hasMany(Oportunidad::class);
    }
}
