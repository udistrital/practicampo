<?php

namespace PractiCampoUD\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;

class CheckRole
{
    use HasRoles;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {
        if (!Auth::check()) {
            return redirect('/');
        }
        if (is_string($role)) {
            $role = [$role];
        }
        $userRole = Auth::user()->id_role;
        //$role= array_map('intval', $role);
        //dd($userRole,'--',$role);
        if (!in_array($userRole, $role)) {
            return redirect('/home')->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        $this->role_verif();

        return $next($request);
    }

    public function role_verif(){
        $user = Auth::user();
        //dd($user->userHasRole($user->id_role));
        //if(!$user->userHasRole($user->id_role)){

        //}
        $exists = DB::table('model_has_roles')
                ->where('model_id', $user->id)
                ->where('role_id', $user->id_role)
                ->exists();
                
        if(!$exists){
            $role = DB::table('roles')
            ->where('id', $user->id_role)
            ->value('name');
            //dd($role);
            $user->assignRole($role);
        }
        return true;
    }
}
