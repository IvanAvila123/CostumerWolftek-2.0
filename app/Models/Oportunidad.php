<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Oportunidad extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait;

    protected $table = 'oportunidads';

    protected $fillable = [
        'vendedor',
        'venta',
        'entrega',
        'autorizada',
        'acuerdo',
        'comentarios',
        'actualizacion',
        'estado',
        'id_ejecutivo',
        'user_id',
        'cliente_id',
    ];

    public function lineas()
{
    return $this->belongsToMany(Linea::class, 'oportunidad_linea')->withPivot('fecha_linea');
}

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function distribuidor()
    {
        return $this->belongsTo(Distribuidor::class, 'id_ejecutivo');
    }
}
