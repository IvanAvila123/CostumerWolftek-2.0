<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Linea extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use AuditableTrait;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [

        'dn',
        'fecha',
        'plan',
        'equipo',
        'cliente_id',
        'user_id',
        'id_distribuidor',
        'order',
        'deleted_at'

    ];

    protected $auditInclude = [
        'dn',
        'fecha',
        'plan',
        'equipo',
        'order'
    ];

    protected $auditExclude = [
        'cliente_id',
        'user_id',
        'id_distribuidor',
        'id'
    ];

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
        return $this->belongsTo(Distribuidor::class);
    }

    public function lineas()
    {
        return $this->belongsToMany(Linea::class, 'oportunidad_linea', 'oportunidad_id', 'linea_id');
    }
}
