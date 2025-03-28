<?php

namespace PractiCampoUD\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PractiCampoUD\User;
use Spatie\Permission\Models\Role;
use Jumbojett\OpenIDConnectClient;
use PractiCampoUD\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class Wso2AuthController extends Controller
{
    public function redirectToWso2()
    {
        if (Auth::check() && session()->has('access_token')) {
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

    public function handleWso2Callback(Request $request)
    {
        try {
            /*$oidc = new OpenIDConnectClient(
                env('WSO2_TOKEN_URL'),
                env('WSO2_CLIENT_ID'),
                env('WSO2_CLIENT_SECRET')
            );
            
            $oidc->providerConfigParam([
                'token_endpoint' => env('WSO2_TOKEN_URL'),
            ]);

            $oidc->setRedirectURL(env('WSO2_REDIRECT_URL'));
            $oidc->authenticate();

            $userInfo = $oidc->getVerifiedClaims();
            dd($userInfo);
            $email = $userInfo->email ?? null;

            if (!$email) {
                return redirect()->route('login')->withErrors(['error' => 'No se recibió un correo válido.']);
            }

            // Buscar o crear usuario en Laravel
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'usuario' => $userInfo->preferred_username ?? $email,
                    'primer_nombre' => $userInfo->given_name ?? '',
                    'primer_apellido' => $userInfo->family_name ?? '',
                    'password' => bcrypt(str()->random(16)),
                ]
            );

            // Obtener roles desde WSO2
            $rolesFromWso2 = $this->getRolesFromWso2($userInfo);

            // Asignar los roles en Laravel
            if ($rolesFromWso2) {
                foreach ($rolesFromWso2 as $role) {
                    if (Role::where('name', $role)->exists()) {
                        $user->assignRole($role);
                    }
                }
            }

            // Guardar el rol activo en la sesión
            session(['user_role' => $rolesFromWso2[0] ?? null]);

            Auth::login($user);

            return redirect()->route('dashboard');*/
            
            $accessToken = $request->query('access_token');
            $idToken = $request->query('id_token');
            $expiresIn = $request->query('expires_in');
            session(['access_token' => $accessToken]);
            session(['id_token' => $idToken]);
            session(['expires_in' => $expiresIn]);
            $parts = explode('.', $idToken);
            $userInfo = json_decode(base64_decode($parts[1]), true);

            //Consulta APIS
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken,
            ])->post('https://autenticacion.portaloas.udistrital.edu.co/apioas/autenticacion_mid/v1/token/userRol', [
                'user' => $userInfo["email"],
                //'user' => "juldgonzalezc@udistrital.edu.co",
            ]);
            $datos_user = $response->json();

            /*$response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get('https://autenticacion.portaloas.udistrital.edu.co/apioas/terceros_crud/v1/vinculacion', [
                'user' => $datos_user["documento"],
            ]);
            $user_vinculacion = $response->json();*/
            //Consulta APIS
            dd($userInfo,$datos_user);
            $user = User::find($datos_user["documento"]);
            if (!$user) {
                //crear user si no lo encuentra
                //en proceso de permisos de apis para obtener toda la información necesaria
                dd($user);
            }
            //dd($user);
            
            //hacer toda la logica para crear usuarios en caso de que no existan
            //hacer toda la logica de asignacion de roles
            //DECANO
            //ASISTENTE_PRACTICAS - DELEGADO_DECANATURA
            //COORDINADOR
            //DOCENTE
            //validar correctamente el Auth (evitar doble ingreso con microsoft) (sincronizar Auth de laravel con el token, utilizar expiración de este o validar con wso2)
            //dd($user);
            Auth::login($user);

            return redirect()->route('home');
            

        } catch (\Exception $e) {
            //return redirect()->route('auth.login')->withErrors(['error' => 'Error en la autenticación con WSO2: ' . $e->getMessage()]);
            dd($e->getMessage());
        }
    }

    private function getRolesFromWso2($userInfo)
    {
        $rolesEnWso2 = $userInfo->roles ?? [];
        $rolesPermitidos = ['DOCENTE', 'COORDINADOR', 'ASISTENTE_DECANATURA', 'DECANO', 'DELEGADO_DECANATURA'];
        return array_intersect($rolesEnWso2, $rolesPermitidos);
    }
}
// 80761795 id user para pruebas - jhon castellanos