<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class programa_academico extends Model
{
    protected $table = 'programa_academico';

    protected $fillable = [
    		'programa_academico'    		
    ];

    public function esp_academico()
    {
        return $this->hasMany(espacio_academico::class);
    }
}
