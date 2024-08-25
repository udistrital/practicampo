<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class practicas_integradas extends Model
{
    protected $table = 'practicas_integradas';
    
    public $timestamps = false;

    protected $fillable = [
        'id',
        'cant_espa_aca',
        'id_espa_aca_1',
        'id_espa_aca_2',
        'id_espa_aca_3',
        'id_espa_aca_4',
        'id_espa_aca_5',
        'id_espa_aca_6',
        'id_espa_aca_7',
        'id_docen_espa_aca_1',
        'id_docen_espa_aca_2',
        'id_docen_espa_aca_3',
        'id_docen_espa_aca_4',
        'id_docen_espa_aca_5',
        'id_docen_espa_aca_6',
        'id_docen_espa_aca_7',
    ];
}
