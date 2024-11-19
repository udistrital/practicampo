<?php

namespace PractiCampoUD\Http\Controllers\Users;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use PractiCampoUD\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PractiCampoUD\User;
use Carbon\Carbon;
use DB;

/**
 * Manejo de usuarios
 * 
 * PHP version 7.2
 * 
 * @category PHP
 * @author LauraGiraldo
 * @copyright 2021 Sitio creado y administrado por la 
 * Facultad de Medio Ambiente y Recursos Naturales de la Universidad Francisco José de Caldas
 * @version 1.0
 * @link http://practicampo.udistrital.edu.co
 */
class UsersController extends Controller
{
    /**
     * Listado de usuarios
     *
     * @param string $filter
     * @return \Illuminate\Http\Response
     */
    public function filterUser($filter)
    {
        try
        {
            $control_sistema =DB::table('control_sistema')->first();
            $idUser = Auth::user()->id;
            $usuario=DB::table('users')
            ->where('id',$idUser)->first();

            switch($filter)
            {
                case 'act':
                    $usuarios=DB::table('users as us')
                    ->join('tipo_identificacion as ti', 'us.id_tipo_identificacion','=', 'ti.id' )
                    ->join('roles as ro', 'us.id_role','=', 'ro.id' )
                    ->select('ti.sigla','us.id', 'us.usuario','us.primer_nombre','us.segundo_nombre', 'us.primer_apellido', 
                    'us.segundo_apellido','ro.name as role', 'us.email', 'us.tiene_firma')
                    ->where('id_estado','=', '1')->paginate(10000);
                    break;
                case 'inac':
                    $usuarios=DB::table('users as us')
                    ->join('tipo_identificacion as ti', 'us.id_tipo_identificacion','=', 'ti.id' )
                    ->join('roles as ro', 'us.id_role','=', 'ro.id' )
                    ->select('ti.sigla','us.id', 'us.usuario','us.primer_nombre','us.segundo_nombre', 'us.primer_apellido', 
                    'us.segundo_apellido','ro.name as role', 'us.email', 'us.tiene_firma')
                    ->where('id_estado','=', '2')->paginate(10000);
                    break;
                case 'all':
                    $usuarios=DB::table('users as us')
                    ->join('tipo_identificacion as ti', 'us.id_tipo_identificacion','=', 'ti.id' )
                    ->join('roles as ro', 'us.id_role','=', 'ro.id' )
                    ->select('ti.sigla','us.id', 'us.usuario','us.primer_nombre','us.segundo_nombre',
                    'us.primer_apellido', 
                    'us.segundo_apellido','ro.name as role', 'us.email', 'us.tiene_firma')->paginate(10000);
                    break;
                default;
            }
            
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla en la consulta.');
        }

        return view('auth.index',['usuarios'=>$usuarios, 
                                    'filter'=>$filter, 
                                    'usuario'=>$usuario,
                                    'control_sistema'=>$control_sistema]);   
    }

    /**
     * Muestra formulario de edición de usuarios
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try
        {
            $control_sistema =DB::table('control_sistema')->first();
            $id=Crypt::decrypt($id);
            $usuario=User::find($id);
            $tipo_identificacion=DB::table('tipo_identificacion')->get();
            $tipo_usuario=DB::table('roles')
            ->select('id', DB::raw('name as role'))
            ->where('id','!=',8)->get();
            $tipo_vinculacion=DB::table('tipo_vinculacion')->get();
            $espacio_academico=DB::table('espacio_academico')->get();
            $programa_academico =DB::table('programa_academico')->get();
            $periodo_academico=DB::table('periodo_academico')->get();

            $espacios_user=DB::table('espacio_academico as esp_aca')
            ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                    'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
            ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
            ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
            $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();

            $esp_aca_user = [];
            switch(count($espacios_user))
            {
                case "1":
                    $esp_aca_user[0] = ['id'=>$espacios_user[0]->id, 'id_programa_academico' =>$espacios_user[0]->id_programa_academico, 
                    'programa_academico' => $espacios_user[0]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[0]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[0]->espacio_academico];
                    $esp_aca_user[1] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[2] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[3] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[4] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[5] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    break;
                case "2":
                    $esp_aca_user[0] = ['id'=>$espacios_user[0]->id, 'id_programa_academico' =>$espacios_user[0]->id_programa_academico, 
                    'programa_academico' => $espacios_user[0]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[0]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[0]->espacio_academico];
                    $esp_aca_user[1] = ['id'=>$espacios_user[1]->id, 'id_programa_academico' =>$espacios_user[1]->id_programa_academico, 
                    'programa_academico' => $espacios_user[1]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[1]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[1]->espacio_academico];
                    $esp_aca_user[2] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[3] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[4] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[5] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    break;
                case "3":
                    $esp_aca_user[0] = ['id'=>$espacios_user[0]->id, 'id_programa_academico' =>$espacios_user[0]->id_programa_academico, 
                    'programa_academico' => $espacios_user[0]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[0]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[0]->espacio_academico];
                    $esp_aca_user[1] = ['id'=>$espacios_user[1]->id, 'id_programa_academico' =>$espacios_user[1]->id_programa_academico, 
                    'programa_academico' => $espacios_user[1]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[1]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[1]->espacio_academico];
                    $esp_aca_user[2] = ['id'=>$espacios_user[2]->id, 'id_programa_academico' =>$espacios_user[2]->id_programa_academico, 
                    'programa_academico' => $espacios_user[2]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[2]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[2]->espacio_academico];
                    $esp_aca_user[3] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[4] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[5] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    break;
                case "4":
                    $esp_aca_user[0] = ['id'=>$espacios_user[0]->id, 'id_programa_academico' =>$espacios_user[0]->id_programa_academico, 
                    'programa_academico' => $espacios_user[0]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[0]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[0]->espacio_academico];
                    $esp_aca_user[1] = ['id'=>$espacios_user[1]->id, 'id_programa_academico' =>$espacios_user[1]->id_programa_academico, 
                    'programa_academico' => $espacios_user[1]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[1]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[1]->espacio_academico];
                    $esp_aca_user[2] = ['id'=>$espacios_user[2]->id, 'id_programa_academico' =>$espacios_user[2]->id_programa_academico, 
                    'programa_academico' => $espacios_user[2]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[2]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[2]->espacio_academico];
                    $esp_aca_user[3] = ['id'=>$espacios_user[3]->id, 'id_programa_academico' =>$espacios_user[3]->id_programa_academico, 
                    'programa_academico' => $espacios_user[3]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[3]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[3]->espacio_academico];
                    $esp_aca_user[4] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[5] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    break;
                case "5":
                    $esp_aca_user[0] = ['id'=>$espacios_user[0]->id, 'id_programa_academico' =>$espacios_user[0]->id_programa_academico, 
                    'programa_academico' => $espacios_user[0]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[0]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[0]->espacio_academico];
                    $esp_aca_user[1] = ['id'=>$espacios_user[1]->id, 'id_programa_academico' =>$espacios_user[1]->id_programa_academico, 
                    'programa_academico' => $espacios_user[1]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[1]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[1]->espacio_academico];
                    $esp_aca_user[2] = ['id'=>$espacios_user[2]->id, 'id_programa_academico' =>$espacios_user[2]->id_programa_academico, 
                    'programa_academico' => $espacios_user[2]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[2]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[2]->espacio_academico];
                    $esp_aca_user[3] = ['id'=>$espacios_user[3]->id, 'id_programa_academico' =>$espacios_user[3]->id_programa_academico, 
                    'programa_academico' => $espacios_user[3]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[3]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[3]->espacio_academico];
                    $esp_aca_user[4] = ['id'=>$espacios_user[4]->id, 'id_programa_academico' =>$espacios_user[4]->id_programa_academico, 
                    'programa_academico' => $espacios_user[4]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[4]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[4]->espacio_academico];
                    $esp_aca_user[5] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    break;
                case "6":
                    $esp_aca_user[0] = ['id'=>$espacios_user[0]->id, 'id_programa_academico' =>$espacios_user[0]->id_programa_academico, 
                    'programa_academico' => $espacios_user[0]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[0]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[0]->espacio_academico];
                    $esp_aca_user[1] = ['id'=>$espacios_user[1]->id, 'id_programa_academico' =>$espacios_user[1]->id_programa_academico, 
                    'programa_academico' => $espacios_user[1]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[1]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[1]->espacio_academico];
                    $esp_aca_user[2] = ['id'=>$espacios_user[2]->id, 'id_programa_academico' =>$espacios_user[2]->id_programa_academico, 
                    'programa_academico' => $espacios_user[2]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[2]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[2]->espacio_academico];
                    $esp_aca_user[3] = ['id'=>$espacios_user[3]->id, 'id_programa_academico' =>$espacios_user[3]->id_programa_academico, 
                    'programa_academico' => $espacios_user[3]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[3]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[3]->espacio_academico];
                    $esp_aca_user[4] = ['id'=>$espacios_user[4]->id, 'id_programa_academico' =>$espacios_user[4]->id_programa_academico, 
                    'programa_academico' => $espacios_user[4]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[4]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[4]->espacio_academico];
                    $esp_aca_user[5] = ['id'=>$espacios_user[5]->id, 'id_programa_academico' =>$espacios_user[5]->id_programa_academico, 
                    'programa_academico' => $espacios_user[5]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[5]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[5]->espacio_academico];
                    break;
            }

        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla en la consulta.');
        }

        return view('auth.edit', [ 'usuario'=>$usuario,
                                   'tipos_identificaciones'=>$tipo_identificacion,
                                   'tipos_usuarios'=>$tipo_usuario,
                                   'tipos_vinculaciones'=>$tipo_vinculacion,
                                   'espacios_academicos'=>$espacio_academico,
                                   'espacios_usuario'=>$esp_aca_user,
                                   'programas_academicos'=>$programa_academico,
                                   'control_sistema'=>$control_sistema
                                   ]);
    }

    /**
     * Actualización de usuarios
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try
        {
            $id=Crypt::decrypt($id);
            $espacios_academicos = $request->get('cod_espacio_academico_');
            $programas_academicos = $request->get('id_programa_academico_');
            $count = count($programas_academicos);
            $cant_espacios_academicos = $request->get('c_espa_aca_user_edit');

            switch($cant_espacios_academicos)
            {
                case "1":
                    $id_espacio_academico_1 = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$programas_academicos[0])
                    ->where('codigo_espacio_academico','=',$espacios_academicos[0])->first();

                    break;
                case "2":
                    $id_espacio_academico_1 = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$programas_academicos[0])
                    ->where('codigo_espacio_academico','=',$espacios_academicos[0])->first();
                    
                    if(!empty($programas_academicos[1]))
                    {
                        $id_espacio_academico_2 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[1])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[1])->first();
                    }
                    break;
                case "3":
                    $id_espacio_academico_1 = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$programas_academicos[0])
                    ->where('codigo_espacio_academico','=',$espacios_academicos[0])->first();
                    
                    if(!empty($programas_academicos[1]))
                    {
                        $id_espacio_academico_2 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[1])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[1])->first();
                    }
                    if(!empty($programas_academicos[2]))
                    {
                        
                        $id_espacio_academico_3 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[2])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[2])->first();
                    }
                    break;
                case "4":
                    $id_espacio_academico_1 = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$programas_academicos[0])
                    ->where('codigo_espacio_academico','=',$espacios_academicos[0])->first();
                    
                    if(!empty($programas_academicos[1]))
                    {
                        $id_espacio_academico_2 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[1])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[1])->first();
                    }
                    if(!empty($programas_academicos[2]))
                    {
                        
                        $id_espacio_academico_3 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[2])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[2])->first();
                    }  
                    if(!empty($programas_academicos[3]))
                    {
                        
                        $id_espacio_academico_4 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[3])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[3])->first();
                    }
                    break;
                case "5":
                    $id_espacio_academico_1 = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$programas_academicos[0])
                    ->where('codigo_espacio_academico','=',$espacios_academicos[0])->first();
                    
                    if(!empty($programas_academicos[1]))
                    {
                        $id_espacio_academico_2 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[1])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[1])->first();
                    }
                    if(!empty($programas_academicos[2]))
                    {
                        
                        $id_espacio_academico_3 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[2])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[2])->first();
                    }  
                    if(!empty($programas_academicos[3]))
                    {
                        
                        $id_espacio_academico_4 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[3])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[3])->first();
                    }
                    if(!empty($programas_academicos[4]))
                    {
                        
                        $id_espacio_academico_5 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[4])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[4])->first();
                    }  
                    break;
                case "6":
                    $id_espacio_academico_1 = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$programas_academicos[0])
                    ->where('codigo_espacio_academico','=',$espacios_academicos[0])->first();

                    if(!empty($programas_academicos[1]))
                    {
                        $id_espacio_academico_2 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[1])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[1])->first();
                    }
                    if(!empty($programas_academicos[2]))
                    {
                        
                        $id_espacio_academico_3 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[2])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[2])->first();
                    }  
                    if(!empty($programas_academicos[3]))
                    {
                        
                        $id_espacio_academico_4 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[3])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[3])->first();
                    }
                    if(!empty($programas_academicos[4]))
                    {
                        
                        $id_espacio_academico_5 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[4])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[4])->first();
                    } 
                    if(!empty($programas_academicos[5]))
                    {
                        
                        $id_espacio_academico_6 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[5])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[5])->first();
                    }   
                    break;
            }
            
            $pass =$request->get('password');
            $mytime=Carbon::now('America/Bogota');
            $usuario=User::where('id', '=', $id)->first();
            $usuario->id_estado=$request->get('id_estado');
                    
            $usuario->primer_nombre=$request->get('primer_nombre');
            $usuario->segundo_nombre=$request->get('segundo_nombre');
            $usuario->primer_apellido=$request->get('primer_apellido');
            $usuario->segundo_apellido=$request->get('segundo_apellido');
            $usuario->id_role=$request->get('id_role');
            $usuario->id_tipo_vinculacion=$request->get('id_tipo_vinculacion');
            $usuario->telefono=$request->get('telefono');
            $usuario->celular=$request->get('celular');
            $usuario->cant_espacio_academico = $cant_espacios_academicos;
            $usuario->id_espacio_academico_1= $id_espacio_academico_1->id;
            $usuario->id_espacio_academico_2= (!empty($id_espacio_academico_2->id))?$id_espacio_academico_2->id:null;
            $usuario->id_espacio_academico_3= (!empty($id_espacio_academico_3->id))?$id_espacio_academico_3->id:null;
            $usuario->id_espacio_academico_4= (!empty($id_espacio_academico_4->id))?$id_espacio_academico_4->id:null;
            $usuario->id_espacio_academico_5= (!empty($id_espacio_academico_5->id))?$id_espacio_academico_5->id:null;
            $usuario->id_espacio_academico_6= (!empty($id_espacio_academico_6->id))?$id_espacio_academico_6->id:null;
            $usuario->id_programa_academico_coord=$request->get('id_programa_academico_coord');
            if(!empty($pass) || $pass != null)
            {
                $usuario->password=Hash::make($pass);
            }

            $usuario->updated_at=$mytime->toDateString();

            $usuario->update();
            DB::commit();
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            return back()->withError('Falla en la actualización.');
        }

        return redirect('users/filtrar/all')->with('success', 'Actualización exitosa');
    }

    /**
     * Muestra formulario de registro de usuarios
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationFormUsers()
    {
        try
        {
            $control_sistema =DB::table('control_sistema')->first();
            $tipo_identificacion=DB::table('tipo_identificacion')->get();
            $tipo_usuario=DB::table('roles')
            ->select('id', DB::raw('name as role'))
            ->where('id','!=',8)->get();
            $programa_academico=DB::table('programa_academico')->get();
            $tipo_vinculacion=DB::table('tipo_vinculacion')->get();
            $espacio_academico=DB::table('espacio_academico')->get();
            $idUser = Auth::user()->id;
            $usuario=DB::table('users')
            ->where('id',$idUser)->first();
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla en la consulta.');
        }

        return view('auth.register',["tipos_identificaciones"=>$tipo_identificacion,
                                     "tipos_usuarios"=>$tipo_usuario,
                                     "programas_academicos"=>$programa_academico,
                                     "tipos_vinculaciones"=>$tipo_vinculacion,
                                     "espacios_academicos"=>$espacio_academico,
                                     "usuario"=>$usuario,
                                     'control_sistema'=>$control_sistema
        ]);
    }

    /**
     * Validadador de datos para registro de usuario
     *
     * @param array $data
     * @return \Illuminate\Http\Response
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'usuario' => ['required', 'string', 'max:40'],
            'primer_nombre' => ['required', 'string', 'max:50'],
            'primer_apellido' => ['required', 'string', 'max:50'],
            'celular' => ['required', 'integer', 'min:6'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'num_identificacion' => ['required', 'integer', 'min:6'],
            'id_tipo_identificacion' => ['required', 'integer', 'max:11'],
            'id_role' => ['required', 'integer', 'max:11'],
            // 'id_categoria' => ['required', 'integer', 'max:13'],
            'id_tipo_vinculacion' => ['required', 'integer', 'max:13'],
            // 'id_espacio_academico_1' => ['required', 'integer'],
        ]);
    }

    /**
     * Crea un nuevo usuario luego de la validación
     *
     * @param  array  $data
     * @return \PractiCampoUD\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        try
        {
            $cant_espacios_academicos = $data['c_espa_aca_user'];
            $espacios_academicos = $data['cod_espacio_academico_'];
            $programas_academicos = $data['id_programa_academico_'];

            switch($cant_espacios_academicos)
            {
                case "1":
                    $id_espacio_academico_1 = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$programas_academicos[0])
                    ->where('codigo_espacio_academico','=',$espacios_academicos[0])->first();

                    break;
                case "2":
                    $id_espacio_academico_1 = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$programas_academicos[0])
                    ->where('codigo_espacio_academico','=',$espacios_academicos[0])->first();
                    
                    if(!empty($programas_academicos[1]))
                    {
                        $id_espacio_academico_2 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[1])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[1])->first();
                    }
                    break;
                case "3":
                    $id_espacio_academico_1 = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$programas_academicos[0])
                    ->where('codigo_espacio_academico','=',$espacios_academicos[0])->first();
                    
                    if(!empty($programas_academicos[1]))
                    {
                        $id_espacio_academico_2 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[1])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[1])->first();
                    }
                    if(!empty($programas_academicos[2]))
                    {
                        
                        $id_espacio_academico_3 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[2])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[2])->first();
                    }
                    break;
                case "4":
                    $id_espacio_academico_1 = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$programas_academicos[0])
                    ->where('codigo_espacio_academico','=',$espacios_academicos[0])->first();
                    
                    if(!empty($programas_academicos[1]))
                    {
                        $id_espacio_academico_2 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[1])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[1])->first();
                    }
                    if(!empty($programas_academicos[2]))
                    {
                        
                        $id_espacio_academico_3 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[2])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[2])->first();
                    }  
                    if(!empty($programas_academicos[3]))
                    {
                        
                        $id_espacio_academico_4 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[3])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[3])->first();
                    }
                    break;
                case "5":
                    $id_espacio_academico_1 = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$programas_academicos[0])
                    ->where('codigo_espacio_academico','=',$espacios_academicos[0])->first();
                    
                    if(!empty($programas_academicos[1]))
                    {
                        $id_espacio_academico_2 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[1])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[1])->first();
                    }
                    if(!empty($programas_academicos[2]))
                    {
                        
                        $id_espacio_academico_3 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[2])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[2])->first();
                    }  
                    if(!empty($programas_academicos[3]))
                    {
                        
                        $id_espacio_academico_4 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[3])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[3])->first();
                    }
                    if(!empty($programas_academicos[4]))
                    {
                        
                        $id_espacio_academico_5 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[4])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[4])->first();
                    }  
                    break;
                case "6":
                    $id_espacio_academico_1 = DB::table('espacio_academico')
                    ->where('id_programa_academico','=',$programas_academicos[0])
                    ->where('codigo_espacio_academico','=',$espacios_academicos[0])->first();

                    if(!empty($programas_academicos[1]))
                    {
                        $id_espacio_academico_2 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[1])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[1])->first();
                    }
                    if(!empty($programas_academicos[2]))
                    {
                        
                        $id_espacio_academico_3 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[2])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[2])->first();
                    }  
                    if(!empty($programas_academicos[3]))
                    {
                        
                        $id_espacio_academico_4 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[3])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[3])->first();
                    }
                    if(!empty($programas_academicos[4]))
                    {
                        
                        $id_espacio_academico_5 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[4])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[4])->first();
                    } 
                    if(!empty($programas_academicos[5]))
                    {
                        
                        $id_espacio_academico_6 = DB::table('espacio_academico')
                            ->where('id_programa_academico','=',$programas_academicos[5])
                            ->where('codigo_espacio_academico','=',$espacios_academicos[5])->first();
                    }   
                    break;
            }

            $idRole =  $data['id_role'];
            if($idRole == 4)
            {
                $id_prog_aca_coord = $data['id_programa_academico_coord'];
                if($id_prog_aca_coord == 999)
                {
                    $id_programa_academico_coord = $programas_academicos[0];
                }
                else
                {
                    $id_programa_academico_coord= $data['id_programa_academico_coord'];
                }
            }
            else
            {
                $id_programa_academico_coord = 999;
            }
            
            $id_tipo_vinculacion = $data['id_tipo_vinculacion'];
            $password = $data['password'];

            if(empty($password) || $password == null)
            {
                $password = $data['id_tipo_identificacion'];
            }
            
            User::create(['id' => $data['num_identificacion'],
                                    'id_tipo_identificacion' => $data['id_tipo_identificacion'],
                                    'expedicion_identificacion'=>$data['expedicion_identificacion'],
                                    'usuario' => $data['usuario'],
                                    'primer_nombre'=> $data['primer_nombre'],
                                    'segundo_nombre'=> $data['segundo_nombre'],
                                    'primer_apellido'=> $data['primer_apellido'],
                                    'segundo_apellido'=> $data['segundo_apellido'],
                                    'email' => $data['email'],
                                    'password' => Hash::make($password),
                                    'id_role' =>$idRole,
                                    'id_tipo_vinculacion' => $id_tipo_vinculacion,
                                    'cant_espacio_academico' => $cant_espacios_academicos,
                                    'id_espacio_academico_1' => $id_espacio_academico_1->id,
                                    'id_espacio_academico_2' => (!empty($id_espacio_academico_2->id))?$id_espacio_academico_2->id:null,
                                    'id_espacio_academico_3' => (!empty($id_espacio_academico_3->id))?$id_espacio_academico_3->id:null,
                                    'id_espacio_academico_4' => (!empty($id_espacio_academico_4->id))?$id_espacio_academico_4->id:null,
                                    'id_espacio_academico_5' => (!empty($id_espacio_academico_5->id))?$id_espacio_academico_5->id:null,
                                    'id_espacio_academico_6' => (!empty($id_espacio_academico_6->id))?$id_espacio_academico_6->id:null,
                                    'id_programa_academico_coord' => $id_programa_academico_coord,
                                    'telefono' => $data['telefono'],
                                    'celular' => $data['celular'],
                                    'id_estado' => '1',

            ]);

            DB::commit();
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            return  back()->withError('Falla en la creación del usuario.');
        }
    }

    /**
     * Inicia el registro de usuario
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        
        return redirect('users/filtrar/all');
    }

    /**
     * Eliminar firma usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function ver_perfil($id)
    {
        try
        {
            $control_sistema =DB::table('control_sistema')->first();
            $id=Crypt::decrypt($id);
            $usuario=User::find($id);
            $tipo_identificacion=DB::table('tipo_identificacion')->get();
            $tipo_usuario=DB::table('roles')
            ->select('id', DB::raw('name as role'))
            ->where('id','!=',8)->get();
            //dd($tipo_usuario);
            $tipo_vinculacion=DB::table('tipo_vinculacion')->get();
            $espacio_academico=DB::table('espacio_academico')->get();
            $programa_academico =DB::table('programa_academico')->get();
            $periodo_academico=DB::table('periodo_academico')->get();

            $espacios_user=DB::table('espacio_academico as esp_aca')
            ->select('esp_aca.id', 'esp_aca.id_programa_academico', 'prog_aca.programa_academico', 'esp_aca.codigo_espacio_academico',
                    'esp_aca.espacio_academico', 'esp_aca.plan_estudios_1', 'esp_aca.plan_estudios_2', 'esp_aca.tipo_espacio')
            ->join('programa_academico as prog_aca','esp_aca.id_programa_academico','=','prog_aca.id')
            ->whereIn('esp_aca.id', [$usuario->id_espacio_academico_1, $usuario->id_espacio_academico_2, $usuario->id_espacio_academico_3, 
            $usuario->id_espacio_academico_4, $usuario->id_espacio_academico_5, $usuario->id_espacio_academico_6])->get();

            $esp_aca_user = [];
            switch(count($espacios_user))
            {
                case "1":
                    $esp_aca_user[0] = ['id'=>$espacios_user[0]->id, 'id_programa_academico' =>$espacios_user[0]->id_programa_academico, 
                    'programa_academico' => $espacios_user[0]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[0]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[0]->espacio_academico];
                    $esp_aca_user[1] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[2] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[3] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[4] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[5] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    break;
                case "2":
                    $esp_aca_user[0] = ['id'=>$espacios_user[0]->id, 'id_programa_academico' =>$espacios_user[0]->id_programa_academico, 
                    'programa_academico' => $espacios_user[0]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[0]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[0]->espacio_academico];
                    $esp_aca_user[1] = ['id'=>$espacios_user[1]->id, 'id_programa_academico' =>$espacios_user[1]->id_programa_academico, 
                    'programa_academico' => $espacios_user[1]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[1]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[1]->espacio_academico];
                    $esp_aca_user[2] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[3] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[4] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[5] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    break;
                case "3":
                    $esp_aca_user[0] = ['id'=>$espacios_user[0]->id, 'id_programa_academico' =>$espacios_user[0]->id_programa_academico, 
                    'programa_academico' => $espacios_user[0]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[0]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[0]->espacio_academico];
                    $esp_aca_user[1] = ['id'=>$espacios_user[1]->id, 'id_programa_academico' =>$espacios_user[1]->id_programa_academico, 
                    'programa_academico' => $espacios_user[1]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[1]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[1]->espacio_academico];
                    $esp_aca_user[2] = ['id'=>$espacios_user[2]->id, 'id_programa_academico' =>$espacios_user[2]->id_programa_academico, 
                    'programa_academico' => $espacios_user[2]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[2]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[2]->espacio_academico];
                    $esp_aca_user[3] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[4] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[5] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    break;
                case "4":
                    $esp_aca_user[0] = ['id'=>$espacios_user[0]->id, 'id_programa_academico' =>$espacios_user[0]->id_programa_academico, 
                    'programa_academico' => $espacios_user[0]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[0]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[0]->espacio_academico];
                    $esp_aca_user[1] = ['id'=>$espacios_user[1]->id, 'id_programa_academico' =>$espacios_user[1]->id_programa_academico, 
                    'programa_academico' => $espacios_user[1]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[1]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[1]->espacio_academico];
                    $esp_aca_user[2] = ['id'=>$espacios_user[2]->id, 'id_programa_academico' =>$espacios_user[2]->id_programa_academico, 
                    'programa_academico' => $espacios_user[2]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[2]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[2]->espacio_academico];
                    $esp_aca_user[3] = ['id'=>$espacios_user[3]->id, 'id_programa_academico' =>$espacios_user[3]->id_programa_academico, 
                    'programa_academico' => $espacios_user[3]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[3]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[3]->espacio_academico];
                    $esp_aca_user[4] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    $esp_aca_user[5] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    break;
                case "5":
                    $esp_aca_user[0] = ['id'=>$espacios_user[0]->id, 'id_programa_academico' =>$espacios_user[0]->id_programa_academico, 
                    'programa_academico' => $espacios_user[0]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[0]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[0]->espacio_academico];
                    $esp_aca_user[1] = ['id'=>$espacios_user[1]->id, 'id_programa_academico' =>$espacios_user[1]->id_programa_academico, 
                    'programa_academico' => $espacios_user[1]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[1]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[1]->espacio_academico];
                    $esp_aca_user[2] = ['id'=>$espacios_user[2]->id, 'id_programa_academico' =>$espacios_user[2]->id_programa_academico, 
                    'programa_academico' => $espacios_user[2]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[2]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[2]->espacio_academico];
                    $esp_aca_user[3] = ['id'=>$espacios_user[3]->id, 'id_programa_academico' =>$espacios_user[3]->id_programa_academico, 
                    'programa_academico' => $espacios_user[3]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[3]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[3]->espacio_academico];
                    $esp_aca_user[4] = ['id'=>$espacios_user[4]->id, 'id_programa_academico' =>$espacios_user[4]->id_programa_academico, 
                    'programa_academico' => $espacios_user[4]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[4]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[4]->espacio_academico];
                    $esp_aca_user[5] = ['id'=>999, 'id_programa_academico' =>999, 
                    'programa_academico' => "N/A", 'codigo_espacio_academico' =>0,
                    'espacio_academico' => "N/A"];
                    break;
                case "6":
                    $esp_aca_user[0] = ['id'=>$espacios_user[0]->id, 'id_programa_academico' =>$espacios_user[0]->id_programa_academico, 
                    'programa_academico' => $espacios_user[0]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[0]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[0]->espacio_academico];
                    $esp_aca_user[1] = ['id'=>$espacios_user[1]->id, 'id_programa_academico' =>$espacios_user[1]->id_programa_academico, 
                    'programa_academico' => $espacios_user[1]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[1]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[1]->espacio_academico];
                    $esp_aca_user[2] = ['id'=>$espacios_user[2]->id, 'id_programa_academico' =>$espacios_user[2]->id_programa_academico, 
                    'programa_academico' => $espacios_user[2]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[2]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[2]->espacio_academico];
                    $esp_aca_user[3] = ['id'=>$espacios_user[3]->id, 'id_programa_academico' =>$espacios_user[3]->id_programa_academico, 
                    'programa_academico' => $espacios_user[3]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[3]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[3]->espacio_academico];
                    $esp_aca_user[4] = ['id'=>$espacios_user[4]->id, 'id_programa_academico' =>$espacios_user[4]->id_programa_academico, 
                    'programa_academico' => $espacios_user[4]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[4]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[4]->espacio_academico];
                    $esp_aca_user[5] = ['id'=>$espacios_user[5]->id, 'id_programa_academico' =>$espacios_user[5]->id_programa_academico, 
                    'programa_academico' => $espacios_user[5]->programa_academico, 'codigo_espacio_academico' =>$espacios_user[5]->codigo_espacio_academico,
                    'espacio_academico' => $espacios_user[5]->espacio_academico];
                    break;
            }

            $firma_lito_DB = $usuario->firma_litografica;
            $img_firma_lito_DB="data:image/png;base64,$firma_lito_DB";

        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla en la consulta.');
        }

        return view('auth.perfil', [ 'usuario'=>$usuario,
                                   'tipos_identificaciones'=>$tipo_identificacion,
                                   'tipos_usuarios'=>$tipo_usuario,
                                   'tipos_vinculaciones'=>$tipo_vinculacion,
                                   'espacios_academicos'=>$espacio_academico,
                                   'espacios_usuario'=>$esp_aca_user,
                                   'programas_academicos'=>$programa_academico,
                                   'img_firma_lito_DB'=>$img_firma_lito_DB,
                                   'control_sistema'=>$control_sistema
                                   ]);
    }

    /**
     * Agregar firma de usuario
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function add_firma_lito(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $control_sistema =DB::table('control_sistema')->first();
            $id_user =  Auth::user()->id;
            $firma_lito= base64_encode(file_get_contents($request->file('firma_lito')->path()));
            
            $user = User::where('id',$id_user)->first();
            
            $w = with($request->file('firma_lito')->path());
            $user->firma_litografica = $firma_lito;
            $user->tiene_firma = 1;
            $user->update();
            
            $user_DB= DB::table('users')
            ->where('id',$id_user)->first();
            
            $firma_lito_DB = $user_DB->firma_litografica;
            $show_firma_lito_DB = base64_decode($firma_lito_DB);
            $img_firma_lito_DB="data:image/png;base64,$firma_lito_DB";

            DB::commit();
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            return back()->withError('Falla al guardar la imágen');
        }

        return view('auth.ver_firma_cargue',['show_firma_lito_DB'=>$show_firma_lito_DB,
                                                'img_firma_lito_DB'=>$img_firma_lito_DB,
                                                'usuario'=>$user,
                                                'control_sistema'=>$control_sistema]);
    }

    /**
     * Ver firma usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function firma_lito()
    {
        try
        {
            $control_sistema =DB::table('control_sistema')->first();
            $id_user =  Auth::user()->id;
            $user = User::where('id',$id_user)->first();
        }
        catch(\Exception $ex)
        {
            return back()->withError('Falla en la consulta.');
        }
        return view('auth.cargue_firma',['usuario'=>$user,
                                            'control_sistema'=>$control_sistema]);
    }

    /**
     * Eliminar firma usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy_firma_lito()
    {
        // try
        // {
            $id_user = Auth::user()->id;
            $user = User::where('id',$id_user)->first();
        //    DB::beginTransaction();
            $control_sistema =DB::table('control_sistema')->first();
            
            $user->firma_litografica = null;
            $user->tiene_firma = 0;
            $user->firma_litografica = NULL;
            $user->update();

        //    DB::commit();
            
        // }
        // catch(\Exception $ex)
        // {
        //     DB::rollback();

        //     $respuesta = $this->firma_lito();
        //     $usuario =$respuesta->usuario;
        //     $control_sistema =$respuesta->usuario->control_sistema;
            
        //     return view('auth.cargue_firma',['usuario'=>$respuesta->usuario,
        //     'control_sistema'=>$respuesta->control_sistema],['error'=>'Property is updated .']);
        // }
        
        return view('auth.cargue_firma',['usuario'=>$user,
                                                'control_sistema'=>$control_sistema]);
    }

    /**
     * Finalizar sesión usuario
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        $request->session()->flash('Acción Exitosa','La sesión se ha cerrado correctamente.');

        //return view('auth.login');
        return redirect('/');
    }

    /**
     * Asegurar la redirección al login
     *
     */
    //public function logout_redirect()
    //{
    //    return redirect('/');
    //}

    /**
     * Buscador de usuarios por palabras claves 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function buscador(Request $request,$id_sel)
    public function buscador(Request $request)
    {

        if($request && ($request->get('searchText')) != null)
        {

            $id[] = 0;
            $control_sistema =DB::table('control_sistema')->first();
            $query=trim($request->get('searchText'));
            $idUser = Auth::user()->id;
            $usuario =DB::table('users')
                    ->where('id',$idUser)->first();

            $searchUser = DB::table('users')
            ->select('users.id as id','users.primer_nombre','users.segundo_nombre','users.primer_apellido','users.segundo_apellido',
                     'users.usuario','tp_ident.sigla','tp_vinc.tipo_vinculacion','users.email','rl.name as role')
            // ->join('espacio_academico as e_aca_1','users.id_espacio_academico_1','=','e_aca_1.id')
            // ->join('espacio_academico as e_aca_2','users.id_espacio_academico_2','=','e_aca_2.id')
            // ->join('espacio_academico as e_aca_3','users.id_espacio_academico_3','=','e_aca_3.id')
            // ->join('espacio_academico as e_aca_4','users.id_espacio_academico_4','=','e_aca_4.id')
            // ->join('espacio_academico as e_aca_5','users.id_espacio_academico_5','=','e_aca_5.id')
            // ->join('espacio_academico as e_aca_6','users.id_espacio_academico_6','=','e_aca_6.id')
            ->join('tipo_vinculacion as tp_vinc','users.id_tipo_vinculacion','tp_vinc.id')
            ->join('roles as rl','users.id_role','rl.id')
            ->join('tipo_identificacion as tp_ident','users.id_tipo_identificacion','tp_ident.id')
            ->where('users.primer_nombre','LIKE','%'.$query.'%')
            ->orWhere('users.segundo_nombre','LIKE','%'.$query.'%')
            ->orWhere('users.primer_apellido','LIKE','%'.$query.'%')
            ->orWhere('users.segundo_apellido','LIKE','%'.$query.'%')            
            ->paginate(500)
            ->appends(request()->query());
            
        }
        else{
            return redirect('proyecciones/filtrar/all');
        }
        return view('auth.buscador.tabla_buscador',['resultadoUsuarios'=>$searchUser, 
                                                                'searchText'=>$query, 
                                                                'usuario'=>$usuario,
                                                                'control_sistema'=>$control_sistema]);
    }

}
