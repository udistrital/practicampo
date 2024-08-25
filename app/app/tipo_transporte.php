<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class tipo_transporte extends Model
{
    protected $table = 'tipo_transporte';
    
    public $timestamps = false;

    protected $fillable = [
        'tipo_transporte',
    ];

    public function transporte()
    {
        return $this->hasMany(transporte_proyeccion::class);
    }
}
