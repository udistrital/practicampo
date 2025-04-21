<?php

namespace PractiCampoUD\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use NumberFormatter;
use PractiCampoUD\User;
/**
 * Página de inicio de acceso
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
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $idUser = Auth::user()->id;

        $usuario = DB::table('users')
                    ->where('id',$idUser)->first();
        
        $control_sistema =DB::table('control_sistema')->first();

        $user = User::find($idUser);
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
            }else{
                session(['roles_disponibles' => $roles_actuales]);
            }
        }        

        return view('home2',['usuario'=>$usuario,
                             'control_sistema'=>$control_sistema]);
    }

    public function ayuda()
    {
        $idUser = Auth::user()->id;

        $usuario = DB::table('users')
                    ->where('id',$idUser)->first();
        
        $control_sistema =DB::table('control_sistema')->first();

        return view('sistema.preg_frec',['usuario'=>$usuario,
                                        'control_sistema'=>$control_sistema]);
    }
}
