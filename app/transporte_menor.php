<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class transporte_menor extends Model implements Auditable
{
    use AuditableTrait;
    
    protected $table = 'transporte_menor';
    
    public $timestamps = false;

    protected $fillable = [
        'id',
        'cant_trans_menor_rp',
        'cant_trans_menor_ra',
        'trans_menor_rp_1',
        'trans_menor_rp_2',
        'trans_menor_rp_3',
        'trans_menor_rp_4',
        'trans_menor_ra_1',
        'trans_menor_ra_2',
        'trans_menor_ra_3',
        'trans_menor_ra_4',
        'vlr_trans_menor_rp_1',
        'vlr_trans_menor_rp_2',
        'vlr_trans_menor_rp_3',
        'vlr_trans_menor_rp_4',
        'vlr_trans_menor_ra_1',
        'vlr_trans_menor_ra_2',
        'vlr_trans_menor_ra_3',
        'vlr_trans_menor_ra_4',
    ];
}
