<?php

namespace PractiCampoUD\Http\Middleware;

use Carbon\Carbon;
use Closure;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PractiCampoUD\User;

class CierreModulos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $modulo)
    {
        $control_sistema = DB::table('control_sistema')->first();
        $usuario = User::where('id', Auth::id())->first();

        if($usuario->hasRole('Docente')){
            $fecha_hoy = Carbon::now('America/Bogota')->format('Y-m-d');
            switch ($modulo) {
            case 'programacion':
                $fecha_apert = $control_sistema->fecha_apert_proy;
                $fecha_cierre = $control_sistema->fecha_cierre_proy;
                break;

            case 'solicitud':
                $fecha_apert = $control_sistema->fecha_apert_solic;
                $fecha_cierre = $control_sistema->fecha_cierre_solic;
                break;

            default:
                return redirect()->route('home')->with('error', 'Módulo no configurado.');
        }

        if ($fecha_hoy < $fecha_apert || $fecha_hoy > $fecha_cierre) {
            return redirect()->route('home')->with('error', 'El módulo está cerrado actualmente.');
        }
        }
        

        return $next($request);
    }
}
