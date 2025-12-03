<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class solicitud extends Model
{
    protected $table = 'solicitud_practica';

    protected $fillable = [
            'id_programacion_practica',
            
    ];
}

