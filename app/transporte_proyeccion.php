<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class transporte_proyeccion extends Model
{
    protected $table = 'transporte_proyeccion';
    
    public $timestamps = false;

    protected $fillable = [
        'id',
        'cant_transporte_rp',
        'cant_transporte_ra',
        'id_tipo_transporte_rp_1',
        'id_tipo_transporte_rp_2',
        'id_tipo_transporte_rp_3',
        'id_tipo_transporte_ra_1',
        'id_tipo_transporte_ra_2',
        'id_tipo_transporte_ra_3',
        'capac_transporte_rp_1',
        'capac_transporte_rp_2',
        'capac_transporte_rp_3',
        'capac_transporte_ra_1',
        'capac_transporte_ra_2',
        'capac_transporte_ra_3',
        'det_tipo_transporte_rp_1',
        'det_tipo_transporte_rp_2',
        'det_tipo_transporte_rp_3',
        'det_tipo_transporte_ra_1',
        'det_tipo_transporte_ra_2',
        'det_tipo_transporte_ra_3',
        'exclusiv_tiempo_rp_1',
        'exclusiv_tiempo_rp_2',
        'exclusiv_tiempo_rp_3',
        'exclusiv_tiempo_ra_1',
        'exclusiv_tiempo_ra_2',
        'exclusiv_tiempo_ra_3',
        'docen_respo_trasnporte_rp',
        'docen_respo_trasnporte_ra',
    ];

    public function tipo_transp_1_rp()
    {
        return $this->belongsTo(tipo_transporte::class,'id_tipo_transporte_rp_1');
    }

    public function tipo_transp_2_rp()
    {
        return $this->belongsTo(tipo_transporte::class,'id_tipo_transporte_rp_2');
    }

    public function tipo_transp_3_rp()
    {
        return $this->belongsTo(tipo_transporte::class,'id_tipo_transporte_rp_3');
    }

    public function tipo_transp_1_ra()
    {
        return $this->belongsTo(tipo_transporte::class,'id_tipo_transporte_ra_1');
    }

    public function tipo_transp_2_ra()
    {
        return $this->belongsTo(tipo_transporte::class,'id_tipo_transporte_ra_2');
    }

    public function tipo_transp_3_ra()
    {
        return $this->belongsTo(tipo_transporte::class,'id_tipo_transporte_ra_3');
    }
}
