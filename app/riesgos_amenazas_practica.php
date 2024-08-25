<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class riesgos_amenazas_practica extends Model
{
    protected $table = 'riesgos_amenazas_practica';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'areas_acuaticas_rp',
        'areas_acuaticas_ra',
        'alturas_rp',
        'alturas_ra',
        'riesgo_biologico_rp',
        'riesgo_biologico_ra',
        'espacios_confinados_rp',
        'espacios_confinados_ra',
    ];
}
