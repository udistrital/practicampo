<?php

namespace PractiCampoUD\Http\Controllers\Notificacion;

use PractiCampoUD\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use PractiCampoUD\Mail\CodigoMail;
use PractiCampoUD\Mail\SistemaMail;
use DB;

// class NotificacionController extends Controller
// {
//     public function send()
//     {
//         $users = DB::table('users')
//         ->where('primer_nombre','=','Laura')
//         ->orWhere('primer_nombre','=','Emilia')->get();

//         $emails = [];

//         foreach($users as $item)
//         {
//             $emails[] = $item->email;
//         }

//         $filter = "";
//         $nueva_proyeccion = "";
//         Mail::bcc($emails)->send(new CodigoMail($filter, $nueva_proyeccion));
//     }

//     public function apertura_proy()
//     {
//         $filter = "apertura_proy";

//         Mail::to("lauritagiraldo.s@gmail.com")->send(new CodigoMail($filter));
//     }

//     public function cierre_proy()
//     {
//         $filter = "cierre_proy";
//         $usuarios =DB::table('users')
//         ->where('id_estado',1)->get();

//         $emails = [];

//         foreach($usuarios as $user)
//         {
//                 $emails[] = ["email"=>$user->email, "role"=>$user->id_role];
//         }

//         foreach($emails as $email)
//         {
//                 Mail::bcc($email['email'])->send(new SistemaMail($filter,$email));
//         }
    

//         $emails = [];

//         foreach($usuarios as $user)
//         {
//                 $emails[] = ["email"=>$user->email, "role"=>$user->id_role];
//         }

//         foreach($emails as $email)
//         {
//                 Mail::bcc($email['email'])->send(new SistemaMail($filter,$email));
//         }
//     }

//     public function creacion_proy($id)
//     {
//         $correos_administrativos = [];
//         $filter = "creacion_proy";
//         $nueva_solicitud = "";
//         $nueva_proyeccion = DB::table('proyeccion_preliminar as proy_pre')
//                             ->select('proy_pre.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 
//                                     'esp_aca.id as id_esp_aca', 'pro_aca.id as id_pro_aca', 'proy_pre.anio_periodo',
//                                     'per_aca.periodo_academico','sem_asig.semestre_asignatura', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'proy_pre.id_docente_responsable',
//                                     DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
//                             ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
//                             ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
//                             ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
//                             ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
//                             ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
//                             ->where('proy_pre.id','=',$id)->first();

//         $id_creador = $nueva_proyeccion->id_docente_responsable;
//         $creador=DB::table('users')->where('id','=',$id_creador)->first();
//         $id_esp_aca = $nueva_proyeccion->id_esp_aca;
//         $id_pro_aca = $nueva_proyeccion->id_pro_aca;
//         $coord =DB::table('users')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
        
//         $emails = [];

//         $emails[] = ["email"=>$creador->email, "role"=>$creador->id_role];
//         $emails[] = ["email"=>$coord->email, "role"=>$coord->id_role];
//         foreach($emails as $email)
//         {
//             Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud,$email,$correos_administrativos));
//         }
//     }

//     public function creacion_solic($id)
//     {
//         $correos_administrativos = [];
//         $filter = "creacion_solic";
//         $nueva_proyeccion = "";

//         $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
//                         ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
//                                 'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca',
//                                 'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
//                                 'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
//                                 DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
//                         ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
//                         ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
//                         ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
//                         ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
//                         ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
//                         ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
//                         ->where('proy_pre.id','=',$id)->first();

//         $id_creador = $nueva_solicitud->id_docente_responsable;
//         $creador=DB::table('users')->where('id','=',$id_creador)->first();
//         $id_esp_aca = $nueva_solicitud->id_esp_aca;
//         $id_pro_aca = $nueva_solicitud->id_pro_aca;
//         $coord =DB::table('users')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
        
//         $emails = [];

//         $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
//         $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];

//         foreach($emails as $email)
//         {

//             Mail::bcc($email)->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud, $email, $correos_administrativos));
//         }  
//     }

//     public function aprob_coord_proy($id)
//     {
//         $correos_administrativos = [];
//         $nueva_proyeccion = "";
//         $nueva_solicitud = "";
//         $filter = "aprob_coord_proy";

//         $nueva_proyeccion = DB::table('proyeccion_preliminar as proy_pre')
//                             ->select('proy_pre.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 
//                                     'esp_aca.id as id_esp_aca', 'pro_aca.id as id_pro_aca','proy_pre.anio_periodo',
//                                     'per_aca.periodo_academico','sem_asig.semestre_asignatura', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'proy_pre.id_docente_responsable',
//                                     DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
//                             ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
//                             ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
//                             ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
//                             ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
//                             ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
//                             ->where('proy_pre.id','=',$id)->first();

//         $id_creador = $nueva_proyeccion->id_docente_responsable;
//         $creador=DB::table('users')->where('id','=',$id_creador)->first();
//         // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
//         $id_pro_aca = $nueva_proyeccion->id_pro_aca;
//         $coord =DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
//         $decano = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.role','=',"Decano")->orWhere('rol.id','=',2)->first();
//         $AsisD = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.role','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
//         $emails = [];

//         $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
//         // $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
//         $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
//         $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];

//         foreach($emails as $email)
//         {

//             Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud, $email, $correos_administrativos));
//         }
//     }

//     public function rechazo_coord_proy($id)
//     {
//         $correos_administrativos = [];
//         $nueva_proyeccion = "";
//         $nueva_solicitud = "";
//         $filter = "rechazo_coord_proy";

//         $nueva_proyeccion = DB::table('proyeccion_preliminar as proy_pre')
//                             ->select('proy_pre.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 
//                                     'esp_aca.id as id_esp_aca', 'pro_aca.id as id_pro_aca','proy_pre.anio_periodo','proy_pre.observ_coordinador',
//                                     'per_aca.periodo_academico','sem_asig.semestre_asignatura', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'proy_pre.id_docente_responsable',
//                                     DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
//                             ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
//                             ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
//                             ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
//                             ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
//                             ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
//                             ->where('proy_pre.id','=',$id)->first();

//         $id_creador = $nueva_proyeccion->id_docente_responsable;
//         $creador=DB::table('users')->where('id','=',$id_creador)->first();
//         // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
//         $id_pro_aca = $nueva_proyeccion->id_pro_aca;
//         $coord =DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('id_programa_academico_coord','=',$id_pro_aca)->first();
//         $decano = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.role','=',"Decano")->orWhere('rol.id','=',2)->first();
//         $AsisD = DB::table('users')->join('roles as rol','users.id_role','rol.id')->where('rol.role','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
//         $emails = [];

//         $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
//         // $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
//         // $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
//         // $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];

//         foreach($emails as $email)
//         {

//             Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud, $email, $correos_administrativos));
//         }
//     }

//     public function aprob_coord_solic($id)
//     {
//         $correos_administrativos = [];
//         $nueva_proyeccion = "";
//         $nueva_solicitud = "";
//         $filter = "aprob_coord_solic";

//         $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
//                     ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
//                             'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca', 'sol_prac.num_resolucion', 'proy_pre.num_acta_consejo_facultad',
//                             'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
//                             'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
//                             DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
//                     ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
//                     ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
//                     ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
//                     ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
//                     ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
//                     ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
//                     ->where('proy_pre.id','=',$id)->first();                    

//         $id_creador = $nueva_solicitud->id_docente_responsable;
//         $creador=DB::table('users')->where('id','=',$id_creador)->first();
//         // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
//         $id_pro_aca = $nueva_solicitud->id_pro_aca;
//         $coord =DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_programa_academico_coord','=',$id_pro_aca)
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Coordinador")->orWhere('rol.id','=',4)->first();
//         $decano = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Decano")->orWhere('rol.id','=',2)->first();
//         $AsisD = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
//         $emails = [];

//         $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
//         $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
//         $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];

//         foreach($emails as $email)
//         {

//             Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud, $email, $correos_administrativos));
//         }
//     }

//     /**
//      * Plan de pácticas
//      */

//      /**
//      * aprob_ejec_solic cuando asistente de decanatura ya ha llenado: sicapital, num resolución, fecha resolución, 
//      * cdp, num avance tesoreria, fecha avance tesoreria
//      */

//     public function aprob_ejec_solic($id)
//     {
//         $correos_administrativos = [];
//         $nueva_proyeccion = "";
//         $nueva_solicitud = "";
//         $filter = "aprob_ejec_solic";
//         $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
//                     ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
//                             'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca', 'sol_prac.num_resolucion', 'proy_pre.num_acta_consejo_facultad',
//                             'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
//                             'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
//                             DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
//                     ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
//                     ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
//                     ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
//                     ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
//                     ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
//                     ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
//                     ->where('proy_pre.id','=',$id)->first();    

//         $id_creador = $nueva_solicitud->id_docente_responsable;
//         $creador=DB::table('users')->where('id','=',$id_creador)->first();
//         // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
//         $id_pro_aca = $nueva_solicitud->id_pro_aca;
//         $coord =DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_programa_academico_coord','=',$id_pro_aca)
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Coordinador")->orWhere('rol.id','=',4)->first();
//         $decano = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Decano")->orWhere('rol.id','=',2)->first();
//         $AsisD = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
//         $emails = [];

//         $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
//         $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
//         $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];

//         foreach($emails as $email)
//         {
//             Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud,$email,$correos_administrativos));
//         }
//     }

//     public function radic_avance_tesor_solic($id)
//     {
//         $correos_administrativos = [];
//         $nueva_proyeccion = "";
//         $nueva_solicitud = "";
//         $filter = "radic_avance_tesor_solic";
//         $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
//                     ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
//                             'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca', 'sol_prac.num_resolucion', 'proy_pre.num_acta_consejo_facultad',
//                             'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
//                             'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
//                             'sol_prac.radicado_financiera', 'sol_prac.num_radicado_financiera', 'sol_prac.fecha_radicado_financiera',
//                             DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
//                     ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
//                     ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
//                     ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
//                     ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
//                     ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
//                     ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
//                     ->where('sol_prac.radicado_financiera','=',1)
//                     ->where('proy_pre.id','=',$id)->first();    

//         $id_creador = $nueva_solicitud->id_docente_responsable;
//         $creador=DB::table('users')->where('id','=',$id_creador)->first();
//         // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
//         $id_pro_aca = $nueva_solicitud->id_pro_aca;
//         $coord =DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_programa_academico_coord','=',$id_pro_aca)
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Coordinador")->orWhere('rol.id','=',4)->first();
//         $decano = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Decano")->orWhere('rol.id','=',2)->first();
//         $AsisD = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
//         $emails = [];

//         $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
//         $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];

//         foreach($emails as $email)
//         {
//             Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud,$email, $correos_administrativos));
//         }
//     }

//     public function info_solic_estudiantes($id)
//     {
//         $correos_administrativos = [];
//         $nueva_proyeccion = "";
//         $nueva_solicitud = "";
//         $filter = "info_solic_estudiantes";
//         $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
//                     ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
//                             'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca', 'sol_prac.num_resolucion', 'proy_pre.num_acta_consejo_facultad',
//                             'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
//                             'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
//                             'sol_prac.radicado_financiera', 'sol_prac.num_radicado_financiera', 'sol_prac.fecha_radicado_financiera',
//                             DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
//                     ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
//                     ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
//                     ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
//                     ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
//                     ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
//                     ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
//                     ->where('sol_prac.radicado_financiera','=',1)
//                     ->where('proy_pre.id','=',$id)->first();    

//         $estudiantes_practica =DB::table('estudiantes_solicitud_practica as estu_prac')
//                     ->join('solicitud_practica as sol_prac', 'estu_prac.id_solicitud_practica', 'sol_prac.id')
//                     ->where('sol_prac.id','=',$id)->get();    

//         $id_creador = $nueva_solicitud->id_docente_responsable;
//         $creador=DB::table('users')->where('id','=',$id_creador)->first();
//         // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
//         $id_pro_aca = $nueva_solicitud->id_pro_aca;
//         $coord =DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_programa_academico_coord','=',$id_pro_aca)
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Coordinador")->orWhere('rol.id','=',4)->first();
//         $decano = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Decano")->orWhere('rol.id','=',2)->first();
//         $AsisD = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
//         $emails = [];

//         $emails[] = ["email"=>$creador->email,"role"=>$creador->id_role];
//         $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];

//         foreach($estudiantes_practica as $estudiante)
//         {
//             $emails[] = ["email"=>$estudiante->email,"role"=>$estudiante->id_role];
//         }

//         foreach($emails as $email)
//         {
//             Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud,$email,$correos_administrativos));
//         }
//     }

//     public function info_transp_vice($id)
//     {
//         $nueva_proyeccion = "";
//         $nueva_solicitud = "";
//         $filter = "info_transp_vice";
//         $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
//                     ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
//                             'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca', 'sol_prac.num_resolucion', 'proy_pre.num_acta_consejo_facultad',
//                             'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
//                             'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
//                             'sol_prac.radicado_financiera', 'sol_prac.num_radicado_financiera', 'sol_prac.fecha_radicado_financiera',
//                             'proy_pre.lugar_salida_rp', 'proy_pre.lugar_regreso_rp','proy_pre.lugar_salida_ra', 'proy_pre.lugar_regreso_ra',
//                             DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
//                     ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
//                     ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
//                     ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
//                     ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
//                     ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
//                     ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
//                     ->where('sol_prac.radicado_financiera','=',1)
//                     ->where('proy_pre.id','=',$id)->first();    

//         $estudiantes_practica =DB::table('estudiantes_solicitud_practica as estu_prac')
//                     ->join('solicitud_practica as sol_prac', 'estu_prac.id_solicitud_practica', 'sol_prac.id')
//                     ->where('sol_prac.id','=',$id)->get();    

//         $id_creador = $nueva_solicitud->id_docente_responsable;
//         $creador=DB::table('users')->where('id','=',$id_creador)->first();
//         // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
//         $id_pro_aca = $nueva_solicitud->id_pro_aca;
//         $coord =DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_programa_academico_coord','=',$id_pro_aca)
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Coordinador")->orWhere('rol.id','=',4)->first();
//         $decano = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Decano")->orWhere('rol.id','=',2)->first();
//         $AsisD = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
//         $ViceAdmin = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Vicerrectoria Administrativa")->orWhere('rol.id','=',6)->first();
//         $emails = [];
//         $correos_administrativos = [];
//         $emails[] = ["email"=>$ViceAdmin->email,"role"=>$ViceAdmin->id_role];
//         $correos_administrativos = $emails;
//         foreach($emails as $email)
//         {
//             Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud,$email, $correos_administrativos));
//         }
//     }

//     public function noti_transp_solic($id)
//     {
//         $nueva_proyeccion = "";
//         $nueva_solicitud = "";
//         $filter = "noti_transp_solic";
//         $nueva_solicitud = DB::table('solicitud_practica as sol_prac')
//                     ->select('sol_prac.id', 'pro_aca.programa_academico', 'esp_aca.espacio_academico', 'esp_aca.codigo_espacio_academico', 'per_aca.periodo_academico',
//                             'pro_aca.id as id_pro_aca', 'esp_aca.id as id_esp_aca', 'sol_prac.num_resolucion', 'proy_pre.num_acta_consejo_facultad',
//                             'sem_asig.semestre_asignatura', 'sol_prac.tipo_ruta', 'proy_pre.destino_rp', 'proy_pre.destino_ra', 'sol_prac.fecha_salida', 'sol_prac.fecha_regreso',
//                             'sol_prac.num_estudiantes', 'sol_prac.num_acompaniantes_apoyo', 'proy_pre.id_docente_responsable',
//                             'sol_prac.radicado_financiera', 'sol_prac.num_radicado_financiera', 'sol_prac.fecha_radicado_financiera',
//                             'proy_pre.lugar_salida_rp', 'proy_pre.lugar_regreso_rp','proy_pre.lugar_salida_ra', 'proy_pre.lugar_regreso_ra',
//                             DB::raw('CONCAT(users.primer_nombre, " ", users.segundo_nombre, " ", users.primer_apellido, " ", users.segundo_apellido) as full_name'))
//                     ->join('proyeccion_preliminar as proy_pre', 'sol_prac.id_proyeccion_preliminar', 'proy_pre.id')
//                     ->join('programa_academico as pro_aca', 'proy_pre.id_programa_academico', 'pro_aca.id')
//                     ->join('espacio_academico as esp_aca', 'proy_pre.id_espacio_academico', 'esp_aca.id')
//                     ->join('periodo_academico as per_aca', 'proy_pre.id_periodo_academico', 'per_aca.id')
//                     ->join('semestre_asignatura as sem_asig', 'proy_pre.id_semestre_asignatura', 'sem_asig.id')
//                     ->join('users', 'proy_pre.id_docente_responsable', 'users.id')
//                     ->where('sol_prac.radicado_financiera','=',1)
//                     ->where('proy_pre.id','=',$id)->first();    

//         $estudiantes_practica =DB::table('estudiantes_solicitud_practica as estu_prac')
//                     ->join('solicitud_practica as sol_prac', 'estu_prac.id_solicitud_practica', 'sol_prac.id')
//                     ->where('sol_prac.id','=',$id)->get();    

//         $id_creador = $nueva_solicitud->id_docente_responsable;
//         $creador=DB::table('users')->where('id','=',$id_creador)->first();
//         // $id_esp_aca = $nueva_proyeccion->id_esp_aca;
//         $id_pro_aca = $nueva_solicitud->id_pro_aca;
//         $coord =DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_programa_academico_coord','=',$id_pro_aca)
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Coordinador")->orWhere('rol.id','=',4)->first();
//         $decano = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Decano")->orWhere('rol.id','=',2)->first();
//         $AsisD = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Asistente Decanatura")->orWhere('rol.id','=',3)->first();
//         $ViceAdmin = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Vicerrectoria Administrativa")->orWhere('rol.id','=',6)->first();
//         $Transporte = DB::table('users')
//                 ->join('roles as rol','users.id_role','rol.id')
//                 ->where('id_estado','=',1)
//                 ->where('rol.role','=',"Transportador")->orWhere('rol.id','=',7)->first();        
//         $emails = [];

//         $emails[] = ["email"=>$coord->email,"role"=>$coord->id_role];
//         $emails[] = ["email"=>$ViceAdmin->email,"role"=>$ViceAdmin->id_role];
//         $emails[] = ["email"=>$decano->email,"role"=>$decano->id_role];
//         $emails[] = ["email"=>$AsisD->email,"role"=>$AsisD->id_role];
//         $emails[] = ["email"=>$Transporte->email,"role"=>$Transporte->id_role];

//         $correos_administrativos = $emails;
//         foreach($emails as $email)
//         {
//             $role = $email['role'];
//             if($role == 7)
//             {
//                 Mail::bcc($email['email'])->send(new CodigoMail($filter,$nueva_proyeccion,$nueva_solicitud,$email, $correos_administrativos));
//             }
//         }
//     }
// }
