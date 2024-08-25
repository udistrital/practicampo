<?php

namespace PractiCampoUD\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use DateTime;
use Carbon\Carbon;
use PractiCampoUD\control_sistema;
use PractiCampoUD\Mail\SistemaMail;
use PractiCampoUD\Console\Commands\Log;
use DB;

class CierreSolic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cierre:solic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cierre Módulo Solicitudes';

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
        $control_sistema = control_sistema::first();
        $usuarios =DB::table('users')
            ->where('id_estado',1)->get();
    
        $emails = [];
    
        foreach($usuarios as $user)
        {
                $emails[] = ["email"=>$user->email, "role"=>$user->id_role];
        }

        if($mytime >= $control_sistema->fecha_cierre_solic && $mytime < $control_sistema->fecha_apert_solic)
        {
            if($control_sistema->estado_solic == 1)
            {
                $control_sistema->estado_solic = 0;
                // \Log::info('estado_solic:'.$control_sistema->estado_solic);     
                

                $filter = "cierre_solic";

                if($control_sistema->noti_cierre_solic == 0)
                {

                    foreach($emails as $email)
                
                    {
                    
                        Mail::bcc($email['email'])->send(new SistemaMail($filter,$email));
                        
                    }
                }

                $control_sistema->update();
            }
           
        }
        else if($mytime >= $control_sistema->fecha_apert_solic && $mytime < $control_sistema->fecha_cierre_solic)
        {
            if($control_sistema->estado_solic == 0)
            {
                $control_sistema->estado_solic = 1;
                // \Log::info('estado_solic:'.$control_sistema->estado_solic);
                

                $filter = "apertura_solic";
            
                if($control_sistema->noti_apert_solic == 0)
                {

                    foreach($emails as $email)
                    {
                        Mail::bcc($email['email'])->send(new SistemaMail($filter,$email));
                    }

                }
                $control_sistema->update();
            }
        }
    }
}
