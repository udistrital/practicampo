<?php

namespace PractiCampoUD\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use PractiCampoUD\image;
use DB;
use Illuminate\Support\Facades\Hash;
use PractiCampoUD\estudiante;
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
     * Solicitud seleccionada
     *
     * @param  int  $id
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $email)
    {
        //cosas para hacer aca: añadir formato responsabilidad estudiante para descargar y que lo suban en pdf
        //que todo vaya a cargue_docs_est, y hacer validaciones si el estudiante añade un nuevo archivo o no
        //que se pueda ver el documento en caso de haber cargado uno previamente
        //poner limite de 500kb
        $id=Crypt::decrypt($id);
        $email=Crypt::decrypt($email);
        $id_sol = $id;
        $estudiante = DB::table('estudiante as e')
            ->select('e.email','esp.id_solicitud_practica','e.id_tipo_identificacion','e.num_identificacion','e.fecha_nacimiento','e.celular',
            'e.eps','esp.aprob_terminos_condiciones')
            ->join('estudiantes_solicitud_practica as esp','esp.email','=','e.email')
            ->where('esp.email','=',$email)
            ->where('esp.id_solicitud_practica','=',$id_sol)->first();         
        $tipo_identificacion=DB::table('tipo_identificacion')->get();
        $doc_req_solicitud = DB::table('documentos_requeridos_solicitud as doc_req')
            ->select('doc_req.vacuna_fiebre_amarilla', 'doc_req.vacuna_tetanos', 'doc_req.permiso_acudiente', 
                    'doc_req.certificado_adicional_1', 'doc_req.certificado_adicional_2', 'doc_req.certificado_adicional_3',
                    'doc_req.detalle_certificado_adcional_1', 'doc_req.detalle_certificado_adcional_2', 'doc_req.detalle_certificado_adcional_3')
            ->where('id',$id_sol)->first();        
        
        $rec_doc= DB::table('estudiantes_solicitud_practica')
            ->where('email', '=', $email)
            ->where('id_solicitud_practica','=',$id_sol)->first();

        $documentFields = [
            'declaracion_responsabilidad',
            'seguro_estudiantil',
            'documento_identificacion',
            'certificado_eps',
            'permiso_acudiente',
            'vacuna_fiebre_amarilla',
            'vacuna_tetanos',            
            'certificado_adicional_1',
            'certificado_adicional_2',
            'certificado_adicional_3'
        ];

        $documentos = [];

        foreach ($documentFields as $field) {
            $base64 = $rec_doc->{$field};

            if ($base64) {
                $documentos[$field] = [
                    'base64' => $base64,
                    'pdf'    => "data:application/pdf;base64,$base64",
                    'image'  => "data:image/png;base64,$base64",
                ];
            } else {
                $documentos[$field] = null;
            }
        }
        return view('estudiantes.cargue_docs_est',["estudiante"=>$estudiante,
                                                "tipos_identificaciones"=>$tipo_identificacion,
                                                "doc_req_solicitud"=>$doc_req_solicitud,
                                                "documentos"=>$documentos]);
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
                return redirect('/loginEst')->with('error', 'Error: No se encuentra el usuario en la base de datos o no está activo');
            }
            else if($estudiante != null || $estudiante->estado_estudiante == 1)
            {
                return view('estudiantes.index_solic_est',["estudiante"=>$estudiante,
                                        "solic_asociadas"=>$solic_asociadas,
                                        "filter"=>$filter]);
            }
        }
        else {
            return redirect('/loginEst')->with('error', 'Error: Credenciales inválidas');
        }
    }

    public function filterEstudiante($filter)
    {
        $details = Auth::guard('estud')->user();
        $email_estudiante =$details->email;
        $estudiante = DB::table('estudiante as esp')
                    ->where('email','=',$email_estudiante)->first();
        $id_solicitudes =DB::table('estudiantes_solicitud_practica as est_prac')
                            ->select('est_prac.id_solicitud_practica')
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
                                    ->join('programacion_practica as p_prel','sol_prac.id_programacion_practica','=','p_prel.id')
                                    ->join('espacio_academico as e_aca','p_prel.id_espacio_academico','=','e_aca.id')
                                    ->join('programa_academico as p_aca','e_aca.id_programa_academico','=','p_aca.id')
                                    ->join('users','p_prel.id_docente_responsable','=','users.id')
                                    ->join('estudiantes_solicitud_practica as est_sol','sol_prac.id','=','est_sol.id_solicitud_practica')
                                    ->where('sol_prac.id',$id_solic->id_solicitud_practica)
                                    ->where('sol_prac.confirm_creador',1)
                                    ->where('sol_prac.confirm_docente',1)
                                    ->where('sol_prac.estado_practica',2)
                                    ->where('sol_prac.listado_estudiantes',0)
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
                                    ->join('programacion_practica as p_prel','sol_prac.id_programacion_practica','=','p_prel.id')
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
        $documentFields = [
            'declaracion_responsabilidad',
            'seguro_estudiantil',
            'documento_identificacion',
            'certificado_eps',
            'permiso_acudiente',
            'vacuna_fiebre_amarilla',
            'vacuna_tetanos',            
            'certificado_adicional_1',
            'certificado_adicional_2',
            'certificado_adicional_3'
        ];

        $rules = [];
        $messages = [];

        foreach ($documentFields as $field) {
            $rules[$field] = 'nullable|file|mimes:pdf|max:200';

            $messages["$field.max"] = "El archivo $field no debe superar los 200 KB.";
            $messages["$field.mimes"] = "El archivo $field debe ser un PDF.";
        }

        $request->validate($rules, $messages);
        try {      
            $id=Crypt::decrypt($id);
            $id_sol=Crypt::decrypt($id_sol);

            DB::beginTransaction();
            $doc_estudiante= estudiantes_practica::where('email', '=', $id)
                            ->where('id_solicitud_practica','=',$id_sol)->first();


            if ($request->hasFile('declaracion_responsabilidad')) {
                $declaracion_responsabilidad = base64_encode(file_get_contents($request->file('declaracion_responsabilidad')->path()));
            } else {
                $declaracion_responsabilidad = $doc_estudiante->declaracion_responsabilidad;
            }

            if ($request->hasFile('seguro_estudiantil')) {
                $seguro_est = base64_encode(file_get_contents($request->file('seguro_estudiantil')->path()));
            } else {
                $seguro_est = $doc_estudiante->seguro_estudiantil;
            }

            if ($request->hasFile('documento_identificacion')) {
                $doc_identif = base64_encode(file_get_contents($request->file('documento_identificacion')->path()));
            } else {
                $doc_identif = $doc_estudiante->documento_identificacion;
            }

            if ($request->hasFile('certificado_eps')) {
                $cert_eps = base64_encode(file_get_contents($request->file('certificado_eps')->path()));
            } else {
                $cert_eps = $doc_estudiante->certificado_eps;
            }

            if ($request->hasFile('permiso_acudiente')) {
                $perm_acud = base64_encode(file_get_contents($request->file('permiso_acudiente')->path()));
            } else {
                $perm_acud = $doc_estudiante->permiso_acudiente;
            }

            if ($request->hasFile('vacuna_fiebre_amarilla')) {
                $vac_fieb_amar = base64_encode(file_get_contents($request->file('vacuna_fiebre_amarilla')->path()));
            } else {
                $vac_fieb_amar = $doc_estudiante->vacuna_fiebre_amarilla;
            }

            if ($request->hasFile('vacuna_tetanos')) {
                $vac_tet = base64_encode(file_get_contents($request->file('vacuna_tetanos')->path()));
            } else {
                $vac_tet = $doc_estudiante->vacuna_tetanos;
            }

            if ($request->hasFile('certificado_adicional_1')) {
                $cert_adic_1 = base64_encode(file_get_contents($request->file('certificado_adicional_1')->path()));
            } else {
                $cert_adic_1 = $doc_estudiante->certificado_adicional_1;
            }

            if ($request->hasFile('certificado_adicional_2')) {
                $cert_adic_2 = base64_encode(file_get_contents($request->file('certificado_adicional_2')->path()));
            } else {
                $cert_adic_2 = $doc_estudiante->certificado_adicional_2;
            }

            if ($request->hasFile('certificado_adicional_3')) {
                $cert_adic_3 = base64_encode(file_get_contents($request->file('certificado_adicional_3')->path()));
            } else {
                $cert_adic_3 = $doc_estudiante->certificado_adicional_3;
            }
            
            $doc_estudiante->declaracion_responsabilidad = $declaracion_responsabilidad;
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
            $doc_estudiante->aprob_terminos_condiciones = 1;
            $doc_estudiante->verificacion_asistencia = 1;
            $doc_estudiante->update();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al cargar los documentos' . $e->getMessage());
        }
        return redirect('/Estudiante/filtrar/sol_estudiante')->with('success', 'Documentos cargados con éxito');
    }

    public function index($email)
    {
        $email=Crypt::decrypt($email);

        $estudiante = DB::table('estudiante as esp')
                        ->where('email','=',$email)->first();

        $id_solicitudes =DB::table('estudiantes_solicitud_practica as est_prac')
                            ->select('est_prac.id_solicitud_practica')
                            ->join('solicitud_practica as s','s.id','=','est_prac.id_solicitud_practica')
                            ->where('aprob_terminos_condiciones',0)
                            ->where('s.listado_estudiantes',0)
                            //->where('verificacion_asistencia',0)
                            ->where('email',$estudiante->email)->get();
        $solic_asociadas = [];
        foreach($id_solicitudes as $id_solic)
        {

            $solic=DB::table('solicitud_practica as sol_prac')
                        ->select('sol_prac.id','p_aca.programa_academico','e_aca.espacio_academico','sol_prac.tipo_ruta',
                                'p_prel.destino_rp','p_prel.destino_ra','sol_prac.fecha_salida',
                                DB::raw('CONCAT_WS(" ",users.primer_nombre, users.segundo_nombre, users.primer_apellido, users.segundo_apellido) as full_name'))
                        ->join('programacion_practica as p_prel','sol_prac.id_programacion_practica','=','p_prel.id')
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

    /**
     * Actualiza los datos básicos del estudiante
     *
     * @param  string $email
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_datos_basicos($email, $id_sol, Request $request)
    {
        try {      
            $email=Crypt::decrypt($email);
            $id=Crypt::decrypt($id_sol);

            $estudiante = estudiante::where('email', '=', $email)->first();
            $estudiante->id_tipo_identificacion = $request->get('id_tipo_identificacion');
            $estudiante->num_identificacion = $request->get('num_identificacion');
            $estudiante->fecha_nacimiento = $request->get('fecha_nacimiento');
            $estudiante->celular = $request->get('celular');
            $estudiante->eps = $request->get('eps'); 

            $doc_estudiante= estudiantes_practica::where('email', '=', $email)
                            ->where('id_solicitud_practica','=',$id)->first();         
            $doc_estudiante->aprob_terminos_condiciones = 1;

            $estudiante->update();
            $doc_estudiante->update();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al cargar los documentos' . $e->getMessage());
        }
        return redirect()->back();
    }
    /**
     * Lista los documentos subidos por un estudiante
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ver_documentos_estudiante(Request $request){
        $rec_doc= DB::table('estudiantes_solicitud_practica')
                    ->where('email', '=', $request->email)
                    ->where('id_solicitud_practica','=',$request->id)->first();
        
        if (!$rec_doc) {
            return response()->json(['error' => 'No se encontraron documentos'], 404);
        }

        $documentFields = [
            'declaracion_responsabilidad',
            'seguro_estudiantil',
            'documento_identificacion',
            'certificado_eps',
            'permiso_acudiente',
            'vacuna_fiebre_amarilla',
            'vacuna_tetanos',            
            'certificado_adicional_1',
            'certificado_adicional_2',
            'certificado_adicional_3'
        ];

        $documentos = [];

        foreach ($documentFields as $field) {
            $base64 = $rec_doc->{$field};

            if ($base64) {
                $documentos[$field] = [
                    'base64' => $base64,
                    'pdf'    => "data:application/pdf;base64,$base64",
                    'image'  => "data:image/png;base64,$base64",
                ];
            } else {
                $documentos[$field] = null;
            }
        }

        return response()->json([
            'documentos' => $documentos
        ]);
    }

    /**
     * Crear un estudiante
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function crear_estudiante(Request $request){
        try {
            $email = strtolower(trim($request->email));

            if (empty($email)) {
                throw new \Exception("El correo institucional está vacío.");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("El correo '$email' no es un correo válido.");
            }
            if (!str_ends_with($email, '@udistrital.edu.co')) {
                throw new \Exception("El correo '$email' no pertenece al dominio @udistrital.edu.co.");
            }
            DB::beginTransaction();
            $estudiante = estudiante::firstOrCreate(['email' => $email],
                [
                    'num_identificacion' => null,
                    'codigo_estudiante' => $request->codigo_estudiante,
                    'password' => Hash::make($request->codigo_estudiante),
                    'nombre_completo'=> $request->nombre_completo,
                    'fecha_nacimiento' => null,
                    'celular' => null,
                    'eps' => null,
                ]
            );

            $estudiante_practica = new estudiantes_practica;
            $estudiante_practica->id_tipo_identificacion = 1;
            $estudiante_practica->id_solicitud_practica = $request->id_solicitud;
            $estudiante_practica->email = $request->email;
            $estudiante_practica->grupo = $request->grupo;
            $estudiante_practica->save();
            DB::commit();

            return response()->json(['message' => 'Estudiante añadido correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Ha ocurrido un error al añadir el estudiante '.$e->getMessage()], 404);
        }
    }

    /**
     * Eliminar un estudiante
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function eliminar_estudiante(Request $request){
        $estudiante_practica = estudiantes_practica::where('id_solicitud_practica',$request->id)
                    ->where('email',$request->email)->first();
        if(!$estudiante_practica){
            return response()->json(['error' => 'No se encontró el estudiante'], 404);
        }
        $estudiante_practica->delete();
        return response()->json(['message' => 'Estudiante eliminado correctamente'], 200);
    }

    /**
     * Verificar la asistencia de un estudiante
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verificar_asistencia_estudiante(Request $request){
        $estudiante_practica = estudiantes_practica::where('id_solicitud_practica',$request->id)
                    ->where('email',$request->email)->first();
        if(!$estudiante_practica){
            return response()->json(['error' => 'No se encontró el estudiante'], 404);
        }
        $estudiante_practica->verificacion_asistencia = (int) $request->valor;
        $estudiante_practica->update();
        return response()->json(['message' => 'Asistencia actualizada correctamente'], 200);
    }

    /**
     * Muestra vista para listar estudiantes por solicitud
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index_listar(){
        $idUser = Auth::user()->id;
        $usuario=DB::table('users')
        ->where('id',$idUser)->first();
        $control_sistema = DB::table('control_sistema')->first();

        $solicitudes=DB::table('solicitud_practica')->orderByDesc('id')->get();
        $estudiantes=DB::table('estudiante')->where('id',0)->get();
        return view('estudiantes.index_listar',["solicitudes"=>$solicitudes,
                                                "estudiantes"=>$estudiantes,
                                                "usuario"=>$usuario,
                                                "control_sistema"=>$control_sistema]);
    }

    /**
     * Carga los estudiantes segun el id de la solicitud
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function listar_estudiantes(Request $request){
        $idUser = Auth::user()->id;
        $usuario=DB::table('users')
        ->where('id',$idUser)->first();
        $control_sistema = DB::table('control_sistema')->first();
        
        $solicitudes=DB::table('solicitud_practica')->orderByDesc('id')->get();
        $estudiantes = DB::table('estudiante as e')
            ->select('e.email','e.num_identificacion','e.codigo_estudiante','e.fecha_nacimiento','e.celular',
            'e.eps', 'e.nombre_completo')
            ->join('estudiantes_solicitud_practica as esp','esp.email','=','e.email')
            ->where('esp.id_solicitud_practica','=',(int)$request->get('id_solicitud'))->get();  
        return view('estudiantes.index_listar',["solicitudes"=>$solicitudes,
                                                "estudiantes"=>$estudiantes,
                                                "usuario"=>$usuario,
                                                "control_sistema"=>$control_sistema]);
    }

    /**
     * Actualiza los datos del estudiante
     *
     * @param  string email
     * * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function update_estudiante($email, Request $request){
        try {            
            DB::beginTransaction();
            $estudiante = estudiante::where('email','=',$email)->first();
            $estudiante->num_identificacion = $request->get('num_identificacion');
            $estudiante->codigo_estudiante = $request->get('codigo_estudiante');
            $estudiante->password = Hash::make($request->get('codigo_estudiante')); 
            $estudiante->nombre_completo = $request->get('nombre_completo');
            $estudiante->email = $request->get('email');
            $estudiante->fecha_nacimiento = $request->get('fecha_nacimiento');
            $estudiante->celular = $request->get('celular');
            $estudiante->eps = $request->get('eps');

            $estudiante->update();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocurrió un error al intentar actualizar el estudiante: '.$e->getMessage());
        }
        
        return response()->json(['message' => 'Estudiante actualizado correctamente'], 200);
    }

    /**
     * Elimina los documentos de los estudiantes en un rango de fechas
     *
     * * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function estudiantes_delete_docs(Request $request){
        try {        
            $columnas = [
                'declaracion_responsabilidad','seguro_estudiantil','documento_identificacion',
                'documento_rh','certificado_eps','permiso_acudiente','vacuna_fiebre_amarilla','vacuna_tetanos','certificado_natacion',
                'certificado_adicional_1','certificado_adicional_2','certificado_adicional_3'
            ];
            $vaciar_columnas = array_fill_keys($columnas, null);

            if (!$request->get('fecha_inicial') || !$request->get('fecha_final')) {
                return redirect()->back()->with('error', 'Las fechas son obligatorias.');
            }

            DB::beginTransaction();
            estudiantes_practica::join('solicitud_practica as s', 's.id', '=', 'id_solicitud_practica')
                ->whereBetween('s.fecha_salida', [$request->get('fecha_inicial'), $request->get('fecha_final')])
                ->update($vaciar_columnas);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar eliminar los documentos: '.$e->getMessage());
        }
        return redirect()->back()->with('success', 'Documentos borrados correctamente');
    }
}
