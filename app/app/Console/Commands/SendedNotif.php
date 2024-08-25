<?php

namespace PractiCampoUD\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use PractiCampoUD\Mail\CodigoMail;
use Illuminate\Support\Facades\Redirect;
use PractiCampoUD\Http\Controllers\Notificacion\NotificacionController;

class SendedNotif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sended:notif';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // return redirect()->route('sendNot');
        // return Redirect::to('mail/send')->with('success', 'Creación exitosa');
        // return redirect()->route('sendNot');
        // Mail::to("lauritagiraldo.s@gmail.com")->send(new CodigoMail);

        return (new NotificacionController)->send();
    }
}
