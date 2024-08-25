<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class materiales_herramientas_proyeccion extends Model
{
    protected $table = 'materiales_herramientas_proyeccion';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'det_materiales_rp',
        'det_materiales_ra',
        'det_otros_boletas_rp',
        'det_otros_boletas_ra',
        'det_guias_baquianos_rp',
        'det_guias_baquianos_ra',
        
    ];
}
