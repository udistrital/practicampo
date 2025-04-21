<?php

namespace PractiCampoUD\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PractiCampoUD\User;
use Spatie\Permission\Models\Role;
use Jumbojett\OpenIDConnectClient;
use PractiCampoUD\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use DB;

class Wso2AuthController extends Controller
{
    /**
     * Redireccion a autenticación OpenIDConnect
     *
     * @return OpenIDConnect
     */
    public function redirectToWso2()
    {
        if (Auth::check() && session()->has('access_token')) {
            //dd(Auth::user(), session()->all());
            return redirect()->route('home');
        }
        
        $oidc = new OpenIDConnectClient(
            env('WSO2_AUTHORIZATION_URL'),
            env('WSO2_CLIENT_ID'),
            env('WSO2_CLIENT_SECRET')
        );

        $oidc->providerConfigParam([
            'authorization_endpoint' => env('WSO2_AUTHORIZATION_URL'),
        ]);

        $oidc->setRedirectURL(env('WSO2_REDIRECT_URL'));
        $oidc->addScope(explode(' ', env('WSO2_SCOPES')));
        $oidc->setResponseTypes(['id_token', 'token']);
        $oidc->addAuthParam(['response_mode' => 'form_post']);
        $oidc->authenticate();
    }

    /**
     * valida todo lo referente a la autenticación y autentica al usuario en la app
     *
     * @param  \Illuminate\Http\Request
     * @return redirect home redirecciona al usuario al home
     */
    public function handleWso2Callback(Request $request)
    {
        try {          
            $accessToken = $request->query('access_token');
            $idToken = $request->query('id_token');
            $expiresIn =(int) $request->query('expires_in');
            session(['access_token' => $accessToken]);
            session(['id_token' => $idToken]);
            
            $expirationTime = now()->addSeconds($expiresIn);
            session(['expires_in' => $expirationTime]);

            $parts = explode('.', $idToken);
            $userInfo = json_decode(base64_decode($parts[1]), true);

            //Consulta APIS
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken,
            ])->post('https://autenticacion.portaloas.udistrital.edu.co/apioas/autenticacion_mid/v1/token/userRol', [
                //'user' => $userInfo["email"],
                'user' => "jeussag@udistrital.edu.co", //"documento" => "79794356"
                //'user' => "anosoriog@udistrital.edu.co",
                //'user' => "wfernandez@udistrital.edu.co", //"documento" => "79494815"
            ]);
            $datos_user = $response->json();
            //dd($datos_user);
            
            //Consulta APIS
            
            $roles_admitidos= $this->roles_admitidos($datos_user["role"]);
            if (empty($roles_admitidos)) {
                return redirect()->route('login')->with('error', 'No tiene ningún rol admitido en la aplicación.');
            } else {
                //dd($roles_admitidos);
                $user = User::find($datos_user["documento"]);                                
                if (!$user) {
                    try{
                        $numero = $datos_user["documento"];
                        $response = Http::withHeaders([
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer ' . $accessToken,
                        ])->get("https://autenticacion.portaloas.udistrital.edu.co/apioas/terceros_crud/v1/datos_identificacion", [
                            'query' => "numero:$numero"
                        ]);
                        $datos_tercero = $response->json()[0]['TerceroId'];
                        //dd($datos_tercero);
                        $password='00000000';
                        $usuario = explode('@', $datos_user["email"])[0];
                        User::create(['id' => $datos_user["documento"],
                                        'id_tipo_identificacion' => 1,
                                        'expedicion_identificacion'=> 'N/A',
                                        'usuario' => $usuario,
                                        'primer_nombre'=> $datos_tercero['PrimerNombre'],
                                        'segundo_nombre'=> $datos_tercero['SegundoNombre'] ?? null,
                                        'primer_apellido'=> $datos_tercero['PrimerApellido'],
                                        'segundo_apellido'=> $datos_tercero['SegundoApellido'] ?? null,
                                        'email' => $datos_user["email"],
                                        'password' => Hash::make($password),
                                        'id_role' => 5,
                                        'id_tipo_vinculacion' => 5, //no se puede obtener info de esto
                                        'cant_espacio_academico' => 0,
                                        'id_espacio_academico_1' => 999,
                                        'id_espacio_academico_2' => null,
                                        'id_espacio_academico_3' => null,
                                        'id_espacio_academico_4' => null,
                                        'id_espacio_academico_5' => null,
                                        'id_espacio_academico_6' => null,
                                        'id_programa_academico_coord' => 999,
                                        'telefono' => null, //no se puede obtener info de esto
                                        'celular' => 0, //no se puede obtener info de esto
                                        'id_estado' => 1,
                        ]);  
                    }catch(\Exception $e){
                        return redirect()->route('login')->with('error', 'Ha ocurrido un error al intentar crear su usuario. ' . $e->getMessage());
                    }
                                 
                }
                $user = User::find($datos_user["documento"]);
                $this->sync_roles_app($user, $roles_admitidos);

                
                if ($user->hasRole("Docente") && $user->cant_espacio_academico == 0) {
                    try{
                        $espacios = [];
                        $response = Http::withHeaders([
                                'Accept' => 'application/json',
                                'Authorization' => 'Bearer ' . $accessToken,
                            ])->get("https://autenticacion.portaloas.udistrital.edu.co/apioas/academica_jbpm/v2/carga_docente_identificacion/{$datos_user["documento"]}");
                        $carga_academica_docente = $response->json();

                        if (isset($carga_academica_docente['docente']['carga'])) {
                            foreach ($carga_academica_docente['docente']['carga'] as $carga_docente) {
                                $codEspacio = $carga_docente['cod_espacio'];
                                $nombreEspacio = $carga_docente['espacio'];
                
                                if (!isset($espacios[$codEspacio])) {
                                    $espacios[$codEspacio] = $nombreEspacio;
                                }
                            }
                            $user->cant_espacio_academico = count($espacios);
                
                            $espaciosIds = array_keys($espacios);
                            for ($i = 0; $i < min(6, count($espaciosIds)); $i++) {
                                $campo = 'id_espacio_academico_' . ($i + 1);
                                $user->$campo = $espaciosIds[$i];
                            }
                
                            $user->save();
                        }

                    }catch(\Exception $e){
                        return redirect()->route('login')->with('error', 'Ha ocurrido un error al intentar actualizar los espacios académicos del docente. ' . $e->getMessage());
                    }                    
                }                
                
                if ($user->hasRole("Coordinador Proyecto") && $user->id_programa_academico_coord == 999) {
                    $id_programas = DB::table('programa_academico')->pluck('id')->toArray();                        
                    foreach($id_programas as $id){
                        $response = Http::withHeaders([
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer ' . $accessToken,
                        ])->get("https://autenticacion.portaloas.udistrital.edu.co/apioas/academica_jbpm/v2/consulta_carrera_condor/{$id}");
                        if ($response->successful()) {
                            $data = $response->json();
                            $documento_coordinador = $data['carreraCondorCollection']['carreraCondor'][0]['numero_documento_coordinador'] ?? null;

                            if ($user->id == $documento_coordinador) {
                                $user->id_programa_academico_coord=$id; 
                                $user->update(); 
                                //dd("Programa académico asignado");
                            }
                        }else{
                            return redirect()->route('login')->with('error', 'Ha ocurrido un error inesperado al realizar una consulta: ' . $e->getMessage());   
                        }
                    }                
                    //$user->id_programa_academico_coord=999; 
                    //$user->update();
                    if($user->id_programa_academico_coord == 999){
                        return redirect()->route('login')->with('error', 'No se encontró un programa académico donde el usuario sea coordinador: ' . $e->getMessage());   
                    }                      
                }
            }
            //dd("prueba");
            Auth::login($user);
            $request->session()->regenerate();


            $roles_actuales = $user->roles->pluck('name', 'id')->toArray();
            $cont=0;
            foreach($roles_actuales as $roles){
                $cont++;
            }        
            if(!session('rol_seleccionado')){
                if($cont<2){
                    foreach ($roles_actuales as $id => $nombre) {
                        session([
                            'rol_seleccionado' => [
                                'id' => $id,
                                'nombre' => $nombre
                            ]
                        ]);
                    }
                    return redirect()->route('home');  
                }else{
                    session(['roles_disponibles' => $roles_actuales]);
                    return redirect()->route('pre_seleccionar_rol');   
                }
            }          

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Ha ocurrido un error inesperado: ' . $e->getMessage());
        }
    }

    /**
     * valida los roles admitidos en la aplicacion provenientes de wso2
     *
     * @param  array  $roleswso2  Lista de roles obtenidos desde WSO2.
     * @return array  Roles permitidos en la aplicación con su respectivo mapeo.
     */
    private function roles_admitidos($roleswso2)
    {
        $rolesPermitidosMapeo = [
            'DECANO' => 2,            
            'ASISTENTE_PRACTICAS' => 3,
            'COORDINADOR' => 4,
            'DOCENTE' => 5,
            'DELEGADO_DECANATURA' => 9,
            //'CONTRATISTA' => 9,
        ];
        return array_intersect_key($rolesPermitidosMapeo, array_flip($roleswso2));
    }

    /**
     * sincroniza los roles de wso2 con los de la app
     *
     * @param  User  $user usuario.
     * @param array  $roles_admitidos Roles del usuario permitidos en la aplicación.
     */
    private function sync_roles_app($user, $roles_admitidos)
    {
        $appRoles = array_values($roles_admitidos); //wso2 roles admitidos

        $roles_actuales = $user->roles->pluck('id')->toArray();
        //dd($appRoles, $roles_actuales);

        // Agrega roles
        foreach ($appRoles as $role) {
            if (!in_array($role, $roles_actuales)) {
                $user->assignRole($role);
            }
        }
        // Elimina roles
        foreach ($roles_actuales as $role) {
            if (!in_array($role, $appRoles)) {
                if ($role == 4) {
                    $user->id_programa_academico_coord = 999;
                    $user->save();
                }
                $user->removeRole($role);
            }
        }
    }
    
    /**
     * selecciona rol para interactuar en la app
     *
     * @param  \Illuminate\Http\Request
     * @return redirect home redirecciona al home después de seleccionar rol
     */
    public function seleccionar_rol(Request $request){
        $roles = Auth::user()->roles->pluck('name', 'id')->toArray();
        $rol = $request->input('rol');
        session([
            'rol_seleccionado' => [
                'id' => $rol,
                'nombre' => $roles[$rol]
            ]
        ]);
        return redirect()->route('home')->with('success', 'Rol seleccionado correctamente.');
    }

    /**
     * redirección a vista para pre seleccionar rol
     *
     * @return redirect pre_seleccionar_rol redirecciona a vista pre_seleccionar_rol
     */
    public function pre_seleccionar_rol(){        
        return view('pre_seleccionar_rol');
    }
}
// 80761795 id user para pruebas - jhon castellanos - tercero_principal_id:9810