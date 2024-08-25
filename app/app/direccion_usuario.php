<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class direccion_usuario extends Model
{
    protected $table = 'direccion_usuario';

    protected $fillable = [
        'id',
        'id_tipo_via_1',
        'id_tipo_via_2',
        'id_prefijo_num_via',
        'id_complemento_via',
        'id_prefijo_compl_via',
        'id_prefijo_cardinal',
        'id_prefijo_placa_1',
        'id_complemento_placa',
        'id_prefijo_compl_placa',
        'id_prefijo_cardinal_placa',
        'id_tipo_ubicacion',
        'id_tipo_residencia',
        'id_prefijo_ubicacion',
        'num_placa_1',
        'num_placa_2',
        'num_via',
        'num_residencia',
        'num_prefijo_ubicacion',
        'nombre_ubicacion',    	
        'datos_adicionales',   	
    ];
}
