<?php

namespace PractiCampoUD\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class CodigoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filter, $nueva_proyeccion, $nueva_solicitud, $email, $correos_administrativos)
    {
        $this->filter = $filter;
        $this->nueva_proyeccion = $nueva_proyeccion;
        $this->nueva_solicitud = $nueva_solicitud;
        $this->email = $email;
        $this->correos_administrativos = $correos_administrativos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $filter= $this->filter;
        $nueva_proyeccion = $this->nueva_proyeccion;
        $nueva_solicitud = $this->nueva_solicitud;
        $email = $this->email;
        $correos_administrativos = $this->correos_administrativos;

        switch($this->filter)
        {

            case "creacion_proy":
                $pract_inte=DB::table('practicas_integradas as prac_int')
                        ->where('prac_int.id',$nueva_proyeccion->id)
                        ->first();

                $espa_aca=DB::table('espacio_academico as espa_aca')
                                    ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                                    // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                                    // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                                    ->where('id',$pract_inte->id_espa_aca_1)
                                    ->orWhere('id',$pract_inte->id_espa_aca_2)
                                    ->orWhere('id',$pract_inte->id_espa_aca_3)
                                    ->orWhere('id',$pract_inte->id_espa_aca_4)
                                    ->orWhere('id',$pract_inte->id_espa_aca_5)
                                    ->orWhere('id',$pract_inte->id_espa_aca_6)
                                    ->orWhere('id',$pract_inte->id_espa_aca_7)->get();
            
                if(count($espa_aca) > 0)
                {
                    foreach($espa_aca as $item)
                    {
                        $espa_pract_int[] =['espacio_academico'=>$item->espacio_academico,
                                'codigo_espacio_academico'=>$item->codigo_espacio_academico];
                    }
                }
                else
                {
                    $espa_pract_int[] =['espacio_academico'=>"",
                                'codigo_espacio_academico'=>""];
                }

                $this->from('practicampo@udistrital.edu.co')
                ->subject('Proyección Preliminar N°'.$nueva_proyeccion->id)
                ->view('notificaciones.correoProyecciones',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos,'espa_pract_int'=>$espa_pract_int]);
                break;

            case "creacion_solic":
                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Solicitud Práctica N°'.$nueva_solicitud->id)
                ->view('notificaciones.correoSolicitudes',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos]);
                break;

            case "aprob_coord_proy":
                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Proyección Preliminar N°'.$nueva_proyeccion->id)
                ->view('notificaciones.correoProyecciones',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos]);
                break;

            case "rechazo_coord_proy":
                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Proyección Preliminar N°'.$nueva_proyeccion->id)
                ->view('notificaciones.correoProyecciones',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos]);
                break;
            
            case "aprob_decano_proy":
                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Proyección Preliminar N°'.$nueva_proyeccion->id)
                ->view('notificaciones.correoProyecciones',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos]);
                break;

            case "rechazo_decano_proy":
                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Proyección Preliminar N°'.$nueva_proyeccion->id)
                ->view('notificaciones.correoProyecciones',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos]);
                break;

            case "cierre_coord_proy":
                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Proyección Preliminar N°'.$nueva_proyeccion->id)
                ->view('notificaciones.correoProyecciones',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos]);
                break;

            case "aprob_coord_solic":
                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Solicitud Práctica N°'.$nueva_solicitud->id)
                ->view('notificaciones.correoSolicitudes',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos]);
                break;

            case "rechazo_coord_solic":
                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Solicitud Práctica N°'.$nueva_solicitud->id)
                ->view('notificaciones.correoSolicitudes',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos]);
                break;

            case "cierre_coord_solic":
                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Solicitud Práctica N°'.$nueva_solicitud->id)
                ->view('notificaciones.correoSolicitudes',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos]);
                break;

            case "aprob_ejec_solic":
                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Solicitud Práctica N°'.$nueva_solicitud->id)
                ->view('notificaciones.correoSolicitudes',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos]);
                break;

            case "radic_avance_tesor_solic":
                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Solicitud Práctica N°'.$nueva_solicitud->id)
                ->view('notificaciones.correoSolicitudes',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos]);
                break;

            case "info_solic_estudiantes":
                $pract_inte=DB::table('practicas_integradas as prac_int')
                        ->where('prac_int.id',$nueva_solicitud->id_proyeccion_preliminar)
                        ->first();

                $espa_aca=DB::table('espacio_academico as espa_aca')
                                    ->select('espa_aca.espacio_academico as espacio_academico','espa_aca.codigo_espacio_academico as codigo_espacio_academico')
                                    // ->join('practicas_integradas as p_int_1','espa_aca.id','p_int_1.id_espa_aca_1')
                                    // ->join('practicas_integradas as p_int_2','espa_aca.id','p_int_1.id_espa_aca_2')
                                    ->where('id',$pract_inte->id_espa_aca_1)
                                    ->orWhere('id',$pract_inte->id_espa_aca_2)
                                    ->orWhere('id',$pract_inte->id_espa_aca_3)
                                    ->orWhere('id',$pract_inte->id_espa_aca_4)
                                    ->orWhere('id',$pract_inte->id_espa_aca_5)
                                    ->orWhere('id',$pract_inte->id_espa_aca_6)
                                    ->orWhere('id',$pract_inte->id_espa_aca_7)->get();
            
                if(count($espa_aca) > 0)
                {
                    foreach($espa_aca as $item)
                    {
                        $espa_pract_int[] =['espacio_academico'=>$item->espacio_academico,
                                'codigo_espacio_academico'=>$item->codigo_espacio_academico];
                    }
                }
                else{
                    $espa_pract_int[] =['espacio_academico'=>"",
                                'codigo_espacio_academico'=>""];
                }

                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Práctica de Campo N°'.$nueva_solicitud->id)
                ->view('notificaciones.correoSolicitudes',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos,'espa_pract_int'=>$espa_pract_int]);
                break;

            case "info_transp_vice":
                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Práctica de Campo N°'.$nueva_solicitud->id)
                ->view('notificaciones.correoSolicitudes',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos]);
                break;

            case "noti_transp_solic":
                $rutas=DB::table('proyeccion_preliminar as proy_pre')
                ->select('ruta_principal','ruta_principal_2','ruta_principal_3','ruta_principal_4','ruta_principal_5','ruta_principal_6',
                'ruta_alterna','ruta_alterna_2','ruta_alterna_3','ruta_alterna_4','ruta_alterna_5','ruta_alterna_6')
                ->where('id',$nueva_solicitud->id_proyeccion_preliminar)->first();

                $rutas_recorrido = [];
                if($nueva_solicitud->tipo_ruta == 1)
                {

                    $rutas_recorrido[]=['ruta_1'=>$rutas->ruta_principal,'ruta_2'=>$rutas->ruta_principal_2,'ruta_3'=>$rutas->ruta_principal_3,
                                        'ruta_4'=>$rutas->ruta_principal_4,'ruta_5'=>$rutas->ruta_principal_5,'ruta_6'=>$rutas->ruta_principal_6];
                }
                else if($nueva_solicitud->tipo_ruta == 2)
                {
                    $rutas_recorrido[]=['ruta_1'=>$rutas->ruta_alterna,'ruta_2'=>$rutas->ruta_alterna_2,'ruta_3'=>$rutas->ruta_alterna_3,
                                        'ruta_4'=>$rutas->ruta_alterna_4,'ruta_5'=>$rutas->ruta_alterna_5,'ruta_6'=>$rutas->ruta_alterna_6];
                }

                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Práctica de Campo N°'.$nueva_solicitud->id)
                ->view('notificaciones.correoSolicitudes',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos,'rutas_recorrido'=>$rutas_recorrido]);
                break;

            case "estud_15_dias":
                $fecha_salida = Carbon::parse($nueva_solicitud->fecha_salida);
                $hoy = Carbon::now();
                $hoy = Carbon::parse($hoy);
                $dias_7 = strtotime('-7 day', strtotime($fecha_salida));
                $dias_7 = date('d-m-Y', $dias_7);

                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Práctica de Campo N°'.$nueva_solicitud->id)
                ->view('notificaciones.correoSolicitudes',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos, 'dias_7'=>$dias_7]);
                break;

            case "estud_8_dias":
                $fecha_salida = Carbon::parse($nueva_solicitud->fecha_salida);
                $hoy = Carbon::now();
                $hoy = Carbon::parse($hoy);
                $dias_7 = strtotime('-7 day', strtotime($hoy));
                $dias_7 = date('d-m-Y', $dias_7);

                return $this->from('practicampo@udistrital.edu.co')
                ->subject('Práctica de Campo N°'.$nueva_solicitud->id)
                ->view('notificaciones.correoSolicitudes',['filter'=>$filter, 'nueva_proyeccion'=>$nueva_proyeccion, 'nueva_solicitud'=>$nueva_solicitud, 'email'=>$email, 
                'correos_administrativos'=>$correos_administrativos, 'dias_7'=>$dias_7]);
                break;

                
        }
        
    }
}
