<?php

namespace PractiCampoUD\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use PractiCampoUD\image;
use DB;
use PractiCampoUD\estudiantes_practica;

/**
 * Acceso a estudiantes 
 * 
 * PHP version 7.2
 * 
 * @category PHP
 * @author LauraGiraldo
 * @copyright 2021 Sitio creado y administrado por la 
 * Facultad de Medio Ambiente y Recursos Naturales de la Universidad Distrital Francisco José de Caldas
 * @version 1.0
 * @link http://practicampo.udistrital.edu.co
 */
class EstudianteController extends Controller
{
    use AuthenticatesUsers;

    protected $guard ='estud';
    /**
     * Muestra formulario de documentación requerida para la
     * proyección seleccionada
     *
     * @param  int  $id
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $email)
    {
        $id=Crypt::decrypt($id);
        $email=Crypt::decrypt($email);
        // $cod_est=Crypt::decrypt($cod_est);
        $id_solicitud = $id;
        $estudiante = DB::table('estudiantes_solicitud_practica as esp')
                        ->where('email','=',$email)
                        // ->where('cod_estudiantil','=',$cod_est)
                        ->where('id_solicitud_practica','=',$id_solicitud)->first();
        
        $tipo_identificacion=DB::table('tipo_identificacion')->get();

        $doc_req_solicitud = DB::table('documentos_requeridos_solicitud as doc_req')
                ->select('doc_req.vacuna_fiebre_amarilla', 'doc_req.vacuna_tetanos', 'doc_req.permiso_acudiente', 
                         'doc_req.certificado_adicional_1', 'doc_req.certificado_adicional_2', 'doc_req.certificado_adicional_3',
                         'doc_req.detalle_certificado_adcional_1', 'doc_req.detalle_certificado_adcional_2', 'doc_req.detalle_certificado_adcional_3')
                ->where('id',$id_solicitud)->first();
        
        return view('estudiantes.cargue_docs_est',["estudiante"=>$estudiante,
                                                   "tipos_identificaciones"=>$tipo_identificacion,
                                                   "doc_req_solicitud"=>$doc_req_solicitud]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Página de acceso al sitio web
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginFormEst()
    {
        return view('auth.loginEst');
    }

    /**
     * acceso estudiante al sitio web
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginEst(Request $request)
    {
        $credenciales = array(
            'email' => $request->get('email'),
            'password' => $request->get('password'),
         );

        if (Auth::guard('estud')->attempt($credenciales)) {
        //if (true) {
            $details = Auth::guard('estud')->user();
            $email_estudiante =$details->email;

            $estudiante = DB::table('estudiantes_solicitud_practica as esp')
                        ->where('email','=',$email_estudiante)->first();
            $solic_asociadas[]=null;
            $filter=null;
            if($estudiante == null || $estudiante->estado_estudiante != 1 )
            {
                Abort('401');
                // return view('auth.fallida_est');
            }
            else if($estudiante != null || $estudiante->estado_estudiante == 1)
            {
                return view('estudiantes.index_solic_est',["estudiante"=>$estudiante,
                                        "solic_asociadas"=>$solic_asociadas,
                                        "filter"=>$filter]);
            }
        }
        else {
            Abort('401');
        }
    }

    public function filterEstudiante($filter)
    {
        $details = Auth::guard('estud')->user();
        $email_estudiante =$details->email;
        $estudiante = DB::table('estudiantes_solicitud_practica as esp')
                    ->where('email','=',$email_estudiante)->first();
        $id_solicitudes =DB::table('estudiantes_solicitud_practica as est_prac')
                            ->select('est_prac.id_solicitud_practica')
                            ->where('aprob_terminos_condiciones',0)
                            ->where('verificacion_asistencia',0)
                            ->where('email',$email_estudiante)->get();        
        switch ($filter){
            case 'sol_estudiante':
                if($estudiante == null || $estudiante->estado_estudiante != 1 )
                {
                    Abort('401');
                    // return view('auth.fallida_est');
                }
                else if($estudiante != null || $estudiante->estado_estudiante == 1)
                {
                    $solic_asociadas = [];
                    foreach($id_solicitudes as $id_solic)
                    {

                        $solic=DB::table('solicitud_practica as sol_prac')
                                    ->select('sol_prac.id','p_aca.programa_academico','e_aca.espacio_academico','sol_prac.tipo_ruta',
                                            'p_prel.destino_rp','p_prel.destino_ra','sol_prac.fecha_salida',
                                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                                    ->join('proyeccion_preliminar as p_prel','sol_prac.id_proyeccion_preliminar','=','p_prel.id')
                                    ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                                    ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                                    ->join('users','p_prel.id_docente_responsable','=','users.id')
                                    ->join('estudiantes_solicitud_practica as est_sol','sol_prac.id','=','est_sol.id_solicitud_practica')
                                    ->where('sol_prac.id',$id_solic->id_solicitud_practica)
                                    ->where('est_sol.habilitado',1)->first();
                        
                        if(!empty($solic) || $solic != null)
                        {
                            $solic_asociadas[] = $solic;
                        }
                    } 
                    return view('estudiantes.index_solic_est',["estudiante"=>$estudiante,
                                                            "solic_asociadas"=>$solic_asociadas,
                                                            "filter"=>$filter]);
                }
            break;

            case 'sol_evaluacion':
                if($estudiante == null || $estudiante->estado_estudiante != 1 )
                {
                    Abort('401');
                    // return view('auth.fallida_est');
                }
                else if($estudiante != null || $estudiante->estado_estudiante == 1)
                {
                    $solic_asociadas = [];
                    foreach($id_solicitudes as $id_solic)
                    {

                        $solic=DB::table('solicitud_practica as sol_prac')
                                    ->select('sol_prac.id','p_aca.programa_academico','e_aca.espacio_academico','sol_prac.tipo_ruta',
                                            'p_prel.destino_rp','p_prel.destino_ra','sol_prac.fecha_salida',
                                            DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                                    ->join('proyeccion_preliminar as p_prel','sol_prac.id_proyeccion_preliminar','=','p_prel.id')
                                    ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                                    ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                                    ->join('users','p_prel.id_docente_responsable','=','users.id')
                                    ->join('estudiantes_solicitud_practica as est_sol','sol_prac.id','=','est_sol.id_solicitud_practica')
                                    ->where('sol_prac.id',$id_solic->id_solicitud_practica)
                                    ->where('est_sol.habilitado',1)->first();
                        
                        if(!empty($solic) || $solic != null)
                        {
                            $solic_asociadas[] = $solic;
                        }
                    } 
                    return view('estudiantes.index_solic_est',["estudiante"=>$estudiante,
                                                            "solic_asociadas"=>$solic_asociadas,
                                                            "filter"=>$filter]);
                }
            break;
        }            
    }

    public function importDoc(Request $request, $id, $id_sol)
    {
        $id=Crypt::decrypt($id);
        $id_sol=Crypt::decrypt($id_sol);

        $seguro_est= $request->file('seguro_estudiantil') != Null ? base64_encode(file_get_contents($request->file('seguro_estudiantil')->path())) : Null;
        $doc_identif= $request->file('documento_identificacion') != Null ? base64_encode(file_get_contents($request->file('documento_identificacion')->path())) : Null;
        $cert_eps= $request->file('certificado_eps') != Null ? base64_encode(file_get_contents($request->file('certificado_eps')->path())) : Null;
        $perm_acud= $request->file('permiso_acudiente') != Null ? base64_encode(file_get_contents($request->file('permiso_acudiente')->path())) : Null;
        $vac_fieb_amar= $request->file('vacuna_fiebre_amarilla') != Null ? base64_encode(file_get_contents($request->file('vacuna_fiebre_amarilla')->path())) : Null;
        $vac_tet= $request->file('vacuna_tetanos') != Null ? base64_encode(file_get_contents($request->file('vacuna_tetanos')->path())) : Null;
        $cert_adic_1= $request->file('certificado_adicional_1') != Null ? base64_encode(file_get_contents($request->file('certificado_adicional_1')->path())) : Null;
        $cert_adic_2= $request->file('certificado_adicional_2') != Null ? base64_encode(file_get_contents($request->file('certificado_adicional_2')->path())) : Null;
        $cert_adic_3= $request->file('certificado_adicional_3') != Null ? base64_encode(file_get_contents($request->file('certificado_adicional_3')->path())) : Null;
       
        $doc_estudiante= estudiantes_practica::where('email', '=', $id)
                        ->where('id_solicitud_practica','=',$id_sol)->first();

        $doc_estudiante->seguro_estudiantil = $seguro_est;
        $doc_estudiante->documento_identificacion = $doc_identif;
        $doc_estudiante->certificado_eps = $cert_eps;
        $doc_estudiante->permiso_acudiente = $perm_acud;
        $doc_estudiante->vacuna_fiebre_amarilla = $vac_fieb_amar;
        $doc_estudiante->vacuna_tetanos = $vac_tet;
        $doc_estudiante->certificado_adicional_1 = $cert_adic_1;
        $doc_estudiante->certificado_adicional_2 = $cert_adic_2;
        $doc_estudiante->certificado_adicional_3 = $cert_adic_3;
        $doc_estudiante->detalle_certificado_adicional_1 = $request->get('detalle_certificado_adicional_1');
        $doc_estudiante->detalle_certificado_adicional_2 = $request->get('detalle_certificado_adicional_2');
        $doc_estudiante->detalle_certificado_adicional_3 = $request->get('detalle_certificado_adicional_3');

        $doc_estudiante->id_tipo_identificacion = $request->get('id_tipo_identificacion');
        $doc_estudiante->num_identificacion = $request->get('num_identificacion');
        $doc_estudiante->fecha_nacimiento = $request->get('fecha_nacimiento');
        $doc_estudiante->eps = $request->get('eps');
        $doc_estudiante->celular = $request->get('celular');
        $doc_estudiante->aprob_terminos_condiciones = 1;
        $doc_estudiante->verificacion_asistencia = 1;

        $doc_estudiante->update();

        $rec_doc= DB::table('estudiantes_solicitud_practica')
                    ->where('email', '=', $id)
                    ->where('id_solicitud_practica','=',$id_sol)->first();

        $ccc1 = $rec_doc->seguro_estudiantil;
        $show_image1 = base64_decode($ccc1);
        $show_pdf1="data:application/pdf;base64,$ccc1";
        $img1="data:image/png;base64,$ccc1";

        $ccc2 = $rec_doc->documento_identificacion;
        $show_image2 = base64_decode($ccc2);
        $show_pdf2="data:application/pdf;base64,$ccc2";
        $img2="data:image/png;base64,$ccc2";

        $ccc4 = $rec_doc->certificado_eps;
        $show_image4 = base64_decode($ccc4);
        $show_pdf4="data:application/pdf;base64,$ccc4";
        $img4="data:image/png;base64,$ccc4";

        $ccc5 = $rec_doc->permiso_acudiente;
        $show_image5 = base64_decode($ccc5);
        $show_pdf5="data:application/pdf;base64,$ccc5";
        $img5="data:image/png;base64,$ccc5";

        $ccc6 = $rec_doc->vacuna_fiebre_amarilla;
        $show_image6 = base64_decode($ccc6);
        $show_pdf6="data:application/pdf;base64,$ccc6";
        $img6="data:image/png;base64,$ccc6";

        $ccc7 = $rec_doc->vacuna_tetanos;
        $show_image7 = base64_decode($ccc7);
        $show_pdf7="data:application/pdf;base64,$ccc7";
        $img7="data:image/png;base64,$ccc7";
        
        $ccc9 = $rec_doc->certificado_adicional_1;
        $show_image9 = base64_decode($ccc9);
        $show_pdf9="data:application/pdf;base64,$ccc9";
        $img9="data:image/png;base64,$ccc9";
        
        $ccc10 = $rec_doc->certificado_adicional_2;
        $show_image10 = base64_decode($ccc10);
        $show_pdf10="data:application/pdf;base64,$ccc10";
        $img10="data:image/png;base64,$ccc10";

        $ccc11 = $rec_doc->certificado_adicional_3;
        $show_image11 = base64_decode($ccc11);
        $show_pdf11="data:application/pdf;base64,$ccc11";
        $img11="data:image/png;base64,$ccc11";

        return view('estudiantes.ppp',["imagen1"=>$show_image1, "img1"=>$img1, "pdf1"=>$show_pdf1,
                                       "imagen2"=>$show_image2, "img2"=>$img2, "pdf2"=>$show_pdf2,
                                       "imagen4"=>$show_image4, "img4"=>$img4, "pdf4"=>$show_pdf4,
                                       "imagen5"=>$show_image5, "img5"=>$img5, "pdf5"=>$show_pdf5,
                                       "imagen6"=>$show_image6, "img6"=>$img6, "pdf6"=>$show_pdf6,
                                       "imagen7"=>$show_image7, "img7"=>$img7, "pdf7"=>$show_pdf7,
                                       "imagen9"=>$show_image9, "img9"=>$img9, "pdf9"=>$show_pdf9,
                                       "imagen10"=>$show_image10, "img10"=>$img10, "pdf10"=>$show_pdf10,
                                       "imagen11"=>$show_image11, "img11"=>$img11, "pdf11"=>$show_pdf11,
                                       "rec_doc"=>$rec_doc]);
        // return view('proyecciones.image',["imagen"=>$show_image, "img"=>$img]);
    }

    public function index($email)
    {
        $email=Crypt::decrypt($email);

        $estudiante = DB::table('estudiantes_solicitud_practica as esp')
                        ->where('email','=',$email)->first();

        $id_solicitudes =DB::table('estudiantes_solicitud_practica as est_prac')
                            ->select('est_prac.id_solicitud_practica')
                            ->where('aprob_terminos_condiciones',0)
                            ->where('verificacion_asistencia',0)
                            ->where('email',$estudiante->email)->get();
        $solic_asociadas = [];
        foreach($id_solicitudes as $id_solic)
        {

            $solic=DB::table('solicitud_practica as sol_prac')
                        ->select('sol_prac.id','p_aca.programa_academico','e_aca.espacio_academico','sol_prac.tipo_ruta',
                                'p_prel.destino_rp','p_prel.destino_ra','sol_prac.fecha_salida',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('proyeccion_preliminar as p_prel','sol_prac.id_proyeccion_preliminar','=','p_prel.id')
                        ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                        ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                        ->join('users','p_prel.id_docente_responsable','=','users.id')
                        ->where('sol_prac.id',$id_solic->id_solicitud_practica)->first();
            
            $solic_asociadas[] = $solic;
        }

        

        if($estudiante == null || $estudiante->estado_estudiante != 1 )
        {
            Abort('401');
        }
        else if($estudiante != null || $estudiante->estado_estudiante == 1)
        {

            return view('estudiantes.index_solic_est',["estudiante"=>$estudiante,
                                                       "solic_asociadas"=>$solic_asociadas]);
        }
    }

    public function authenticated(Request $request)
    {
        $email = Crypt::encrypt($request->email);
        $cod_est = Crypt::encrypt($request->password);
        
        // $this->indexrr($email,$cod_est);
        // return view('auth.loginEst');
        return redirect()->action('EstudianteController@index',['email'=>$email,'cod_est'=>$cod_est]);
    }
}
