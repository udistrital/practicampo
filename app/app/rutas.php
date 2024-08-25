<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class rutas extends Model
{
    protected $fillable = [
        'programa_academico',
        'espacio_academico',
        'destino',
        'fecha_salida',
        'fecha_regreso',
        'tipo_ruta'
];
}
