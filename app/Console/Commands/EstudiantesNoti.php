<?php

namespace PractiCampoUD\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use PractiCampoUD\control_sistema;
use PractiCampoUD\estudiantes_practica;
use PractiCampoUD\Mail\CodigoMail;
use DB;

class EstudiantesNoti extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'estudiante:noti';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notificaciones Estudiantes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mytime = Carbon::now();
        $mytime = $mytime->toDateString();
        $solicitudes=DB::table('solicitud_practica as sol_prac')
                        ->where('sol_prac.aprobacion_asistD','=',7)
                        ->where('sol_prac.radicado_financiera','=',1)->get();

        if(!empty($solicitudes) || $solicitudes != null)
        {
            foreach($solicitudes as $sol)
            {
                $fecha_salida = Carbon::parse($sol->fecha_salida);
                $hoy = Carbon::now();
                $hoy = Carbon::parse($hoy);
                $faltantes = $hoy->diffInDays($fecha_salida);
    
                $estud_doc=estudiantes_practica::where('id_solicitud_practica', '=', $sol->id)->get();
    
                if($faltantes == 15)
                {
                    if(!empty($estud_doc) || $estud_doc != null)
                    {
                        foreach($estud_doc as $est_d)
                        {
                            $this->estud_15_dias($sol->id);
                            
                            // \Log::info('id:'.$sol->id.'faltantes:'.$faltantes.'hab:'.$est_d->habilitado.'noti_15_dias:'.$est_d->noti_15_dias = 1);     
                        }
                    }
    
                }
                else if($faltantes == 8)
                {
                    $this->estud_8_dias($sol->id);
                }
                else if($faltantes == 7)
                {
                    $estudiantes_practica=estudiantes_practica::where('id_solicitud_practica',$sol->id)
                    ->where('noti_15_dias',1)
                    ->where('noti_8_dias',1)
                    ->where('habilitado',1)->get();

                    if(!empty($estudiantes_practica) || $estudiantes_practica != null)
                    {
                        foreach($estudiantes_practica as $estudiante)
                        {
                            $estudiante->habilitado = 0;
                            $estudiante->update();
                        }
                    }
                }            
            }
        }

    }

    public function estud_15_dias($id)
    {
        $correos_administrativos = [];
        $nueva_proyeccion = "";
        $nueva_solicitud = "";
        $filter = "estud_15_dias";

        $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
                        ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
                                'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca',
                                'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
                                'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
                                DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                        ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
                        ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                        ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                        ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                        ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                        ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                        ->where('sol_prac.id','=',$id)->first();

        $estudiantes_practica=estudiantes_practica::where('id_solicitud_practica',$nueva_solicitud->id)
                        ->where('noti_15_dias',0)->get(); 

        $emails = [];

        if(!empty($estudiantes_practica) || $estudiantes_practica != null)
        {
            foreach($estudiantes_practica as $estudiante)
            {
                
                $emails[] = ["email"=>$estudiante->email,"role"=>$estudiante->id_role];
                $estudiante->noti_15_dias = 1;
                $estudiante->update();
            }
    
            foreach($emails as $email)
            {
    
                Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud, $email, $correos_administrativos ));
            }
        }    
        
    }

    public function estud_8_dias($id)
    {
        $correos_administrativos = [];
        $nueva_proyeccion = "";
        $nueva_solicitud = "";
        $filter = "estud_8_dias";

        $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
                        ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
                                'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca',
                                'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
                                'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
                                DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
                        ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
                        ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
                        ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
                        ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
                        ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
                        ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
                        ->where('sol_prac.id','=',$id)->first();  

        $estudiantes_practica=estudiantes_practica::where('id_solicitud_practica',$nueva_solicitud->id)
                            ->where('noti_8_dias',0)->get();

        $emails = [];

        if(!empty($estudiantes_practica) || $estudiantes_practica != null)
        {
            foreach($estudiantes_practica as $estudiante)
            {
                $emails[] = ["email"=>$estudiante->email,"role"=>$estudiante->id_role,"cod_estudiantil"=>$estudiante->cod_estudiantil];
                $estudiante->noti_8_dias = 1;
                $estudiante->update();
            }
    
            foreach($emails as $email)
            {
                Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud, $email, $correos_administrativos ));
            }
        }

    }
}
