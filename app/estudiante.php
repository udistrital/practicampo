<?php

namespace PractiCampoUD;

use Illuminate\Foundation\Auth\Estudiante as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class estudiante extends Authenticatable
{
    // protected $guard='estud';
    protected $table = 'estudiante';

    public $timestamps = false;

    protected $fillable = [
        'id_role',
        'email',
        'password',
        'id_tipo_identificacion',
        'num_identificacion',
        'codigo_estudiante',
        'nombre_completo',
        'fecha_nacimiento',
        'celular',
        'eps',        
        'estado_estudiante',        
    ];

    protected $hidden = [
        'password', 
    ];

    public function estudiante()
    {
        return $this->id_role === 8;
    }
    public function getAuthPasswordName()
    {
        return 'password';
    }
}
