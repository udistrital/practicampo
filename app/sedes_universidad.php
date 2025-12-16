<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class sedes_universidad extends Model
{
    protected $table = 'sedes_universidad';

    protected $fillable = [
    		'sede',
            'direccion' 	
    ];

    public $timestamps = false;
}
