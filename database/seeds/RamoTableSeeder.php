<?php

use Illuminate\Database\Seeder;
use App\Ramo;

class RamoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ramos')->truncate();

        $ramos = [

            [
                'especialidade_id' => 3,
                'nome'             => 'personal trainer'
            ],
            [
                'especialidade_id' => 3,
                'nome'             => 'preparador físico'
            ],
            [
                'especialidade_id' => 3,
                'nome'             => 'massagista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'cardiologista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'gastroenterologista'

            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'endocrinologista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'clínico geral'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'ortopedista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'pediatra'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'dermatologista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'oncologista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'pneumologista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'psiquiatra'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'geriatra'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'mastologista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'neurologista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'oftalmologista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'reumatologista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'nefrologista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'urologista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'cirurgião plástico'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'anestesista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'otorrinolaringologista'
            ],
            [
                'especialidade_id' => 5,
                'nome'             => 'angiologista'
            ]
        ];

        foreach($ramos as $ramo)
        {
            Ramo::create($ramo);
        }
    }
}
