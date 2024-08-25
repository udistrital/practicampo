<?php

namespace PractiCampoUD;

use Illuminate\Foundation\Auth\Estudiante as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class estudiantes_practica extends Authenticatable
{
    // protected $guard='estud';
    protected $table = 'estudiantes_solicitud_practica';

    public $timestamps = false;

    protected $fillable = [
        'num_identificacion',
        'id_tipo_identificacion',
        'password',
        'id_solicitud_practica',
        'nombre_completo',
        'fecha_nacimiento',
        'eps',
        'email',
        'grupo',
        'celular',
        'aprob_terminos_condiciones',
        'seguro_estudiantil',
        'verificacion_asistencia',
        'documento_identificacion',
        'documento_rh',
        'certificado_eps',
        'permiso_acudiente',
        'seguro_estudiantil',
        'permiso_acudiente',
        'vacuna_fiebre_amarilla',
        'vacuna_tetanos',
        'certificado_adicional_1',
        'certificado_adicional_2',
        'certificado_adicional_3',
        'detalle_certificado_adicional_1',
        'detalle_certificado_adicional_2',
        'detalle_certificado_adicional_3',
        'noti_15_dias',
        'noti_8_dias',
        'habilitado',
        'grupo',
        'id_role',
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
