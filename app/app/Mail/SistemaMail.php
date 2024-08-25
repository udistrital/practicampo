<?php

namespace PractiCampoUD\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use PractiCampoUD\control_sistema;
use DB;

class SistemaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filter,$email)
    {
        $this->filter = $filter;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $filter= $this->filter;
        $email= $this->email;
        $control_sistema=DB::table('control_sistema as ctr_sistema')->first();

        return $this->from('practicampo@udistrital.edu.co')
                    ->subject('Notificación PractiCampoUD')
                    ->view('notificaciones.correoSistema',['filter'=>$filter,'email'=>$email,'control_sistema'=>$control_sistema]);
    }
}
