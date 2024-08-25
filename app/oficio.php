<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class oficio extends Model
{
    protected $table = 'oficio';
    public $timestamps = false;
    protected $fillable = [
            'parr_1',
            'parr_2',
            'parr_3',
            'parr_4', 		
    ];
}