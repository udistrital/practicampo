<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class costos_proyeccion extends Model
{
    protected $table = 'costos_proyeccion';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'vlr_materiales_rp',
        'vlr_materiales_ra',
        'vlr_otros_boletas_rp',
        'vlr_otros_boletas_ra',
        'vlr_guias_baquianos_rp',
        'vlr_guias_baquianos_ra',
        'viaticos_estudiantes_rp',
        'viaticos_estudiantes_ra',
        'viaticos_docente_rp',
        'viaticos_docente_ra',
        'costo_total_transporte_menor_rp',
        'costo_total_transporte_menor_ra',
        'total_presupuesto_rp',
        'total_presupuesto_ra',
        'valor_estimado_transporte_rp',
        'valor_estimado_transporte_ra',
    ];
}
