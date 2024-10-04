<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Cliente extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;

    protected $fillable = [
        'razon',
        'cuenta',
        'id_cliente',
        'representante',
        'telefono',
        'correo',
        'fiscal',
        'entrega',
        'rfc',
        'vendedor_adquisicion',
        'fecha_adquisicion',
        'ejecutivo',
        'user_id',
    ];

    protected $dates = ['fecha_adquisicion'];

    public function adquisicionExpirada()
    {
        if (!$this->fecha_adquisicion) {
            return true;
        }

        // Asegurarse de que fecha_adquisicion sea un objeto Carbon
        $fechaAdquisicion = $this->fecha_adquisicion instanceof Carbon
            ? $this->fecha_adquisicion
            : Carbon::parse($this->fecha_adquisicion);

        return $fechaAdquisicion->addDays(5)->isPast();
    }

    public function vendedorAdquisicion()
    {
        return $this->belongsTo(User::class, 'vendedor_adquisicion');
    }

    public function distribuidor()
    {
        return $this->belongsTo(Distribuidor::class, 'ejecutivo');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function lineas()
    {
        return $this->hasMany(Linea::class);
    }

    public function oportunidad()
    {
        return $this->hasMany(Oportunidad::class);
    }
}
