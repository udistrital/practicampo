<?php

namespace PractiCampoUD;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PractiCampoUD\Notifications\ResetPasswordNotification;



class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';

    protected $fillable = [
        'id',
        'usuario', 
        'email', 
        'password', 
        'id_role',
        'id_tipo_identificacion',
        'expedicion_identificacion',
        'id_tipo_vinculacion',
        'id_categoria',
        'id_estado',
        'cant_espacio_academico',
        'id_espacio_academico_1',
        'id_espacio_academico_2',
        'id_espacio_academico_3',
        'id_espacio_academico_4',
        'id_espacio_academico_5',
        'id_espacio_academico_6',
        'id_programa_academico',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'telefono',
        'celular',
        'id_programa_academico_coord',
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function espa_aca1()
    {
        return $this->belongsTo(espacio_academico::class,'id_espacio_academico_1');
    }

    public function espa_aca2()
    {
        return $this->belongsTo(espacio_academico::class,'id_espacio_academico_2');
    }

    public function espa_aca3()
    {
        return $this->belongsTo(espacio_academico::class,'id_espacio_academico_3');
    }

    public function espa_aca4()
    {
        return $this->belongsTo(espacio_academico::class,'id_espacio_academico_4');
    }

    public function espa_aca5()
    {
        return $this->belongsTo(espacio_academico::class,'id_espacio_academico_5');
    }

    public function espa_aca6()
    {
        return $this->belongsTo(espacio_academico::class,'id_espacio_academico_6');
    }

    public function adminPerm()
    {
        return (($this->id_role === 1 || $this->id_role === 2 || $this->id_role === 3) && ($this->id_estado === 1));
    }

    public function otrosPerm()
    {
        return (($this->id_role === 1 || $this->id_role === 2 || $this->id_role === 3 || $this->id_role === 4 || $this->id_role === 5 || $this->id_role === 6 || $this->id_role === 7) 
        && ($this->id_estado === 1));
    }

    public function admin()
    {
        return (($this->id_role === 1) && ($this->id_estado === 1));
    }

    public function decano()
    {
        return $this->id_role === 2;
    }

    public function asistenteD()
    {
        return $this->id_role === 3;
    }
    
    public function coordinador()
    {
        return $this->id_role === 4;
    }

    public function docente()
    {
        return $this->id_role === 5;
    }

    public function viceAcademica()
    {
        return $this->id_role === 6;
    }

    public function transportador()
    {
        return $this->id_role === 7;
    }

    public function activo()
    {
        return ($this->id_estado === 1);
    }

    public function inactivo()
    {
        return ($this->id_estado === 2);
    }
    
    // public function usuario()
    // {
    //     return $this->id_role !== 1;
    // }

    public function estudiante()
    {
        return $this->id_role === 8;
    }
}
