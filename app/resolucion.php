<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class resolucion extends Model
{
    protected $table = 'resolucion';
    public $timestamps = false;
    protected $fillable = [
            'parr_1',
            'parr_2',
            'parr_3',
            'parr_4',
            'parr_5',
            'parr_6',
            'parr_7',
            'parr_8',
            'parr_9',
            'parr_10',
            'parr_11',
            'parr_12',
            'parr_13',
            'parr_14',
            'parr_15',
            'parr_16', 		
    ];
}