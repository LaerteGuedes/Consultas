<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Mail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:teste';

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
        $user = null;
        \Illuminate\Support\Facades\Mail::send('emails.boasvindasusuario', ['user' => $user], function ($m) use ($user) {
            $m->from('noreply@sallus.net', 'Sallus - Secretaria Virtual');

            $m->to('laerteguedes8@gmail.com', 'Laerte')->subject('Bem-vindo!');
        });
    }
}
