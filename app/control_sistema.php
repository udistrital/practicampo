<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class control_sistema extends Model
{
    protected $table = 'control_sistema';
    public $timestamps = false;
    protected $fillable = [
            'fecha_apertura_proy',
            'fecha_cierre_proy',
            'fecha_apertura_solic',
            'fecha_cierre_solic',    		
    ];
}
