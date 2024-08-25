<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class encuesta_transporte extends Model
{
    protected $table = 'encuesta_transporte';
    
    public $timestamps = false;

    protected $fillable = [
        'id',
        'cumplio_expect',
        'ruta_prevista',
        'carac_solicitadas',
        'comport_adecuado',
        'horar_estab',
        'nov_cron_ruta',
        'adecuado_traslado',
        'no_adecuado_traslado',
        'con_nov_cron_ruta',
        'no_horar_estab',
        'no_comport_adecuado',
        'no_carac_solicitadas',
        'no_ruta_prevista',
        'no_cumplio_expect',
    ];
}
