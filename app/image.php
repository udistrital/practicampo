<?php

namespace PractiCampoUD;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $table = 'images';
    public $timestamps = false;
    protected $fillable = [
    		'image'    		
    ];
}
