<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class documentos_requeridos_solicitud extends Model
{
    protected $table = 'documentos_requeridos_solicitud';

    public $timestamps = false;

    protected $fillable = [
        'seguro_estudiantil',
        'documento_identificacion',
        'documento_rh',
        'certificado_eps',
        'permiso_acudiente',
        'vacuna_fiebre_amarilla',
        'vacuna_tetanos',
        'certificado_natacion',
        'certificado_adicional_1',
        'certificado_adicional_2',
        'certificado_adicional_3',
        'detalle_certificado_adcional_1',
        'detalle_certificado_adcional_2',
        'detalle_certificado_adcional_3',
    ];
}
