<?php

use Illuminate\Database\Seeder;
use App\Especialidade;

class EspecialidadeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('especialidades')->truncate();

        $nomes = ['nutricionista','fisioterapeuta','educador físico','odontologista','médico',

                  'enfermeiro','fonoaudiólogo','psicólogo','téc. em enfermagem','assistente social',

                  'terapeuta ocupacional', 'radiologista' , 'téc. em radiologia'
                ];

        foreach($nomes as $nome)
        {
            Especialidade::create([
                'nome' => $nome
            ]);
        }

    }
}
