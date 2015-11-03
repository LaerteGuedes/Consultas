<?php

use Illuminate\Database\Seeder;
use App\Bairro;

class BairroTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bairros')->truncate();

        $bairros = [

            [
                'cidade_id' => 4564,
                'nome'      => 'Pedreira'
            ],
            [
                'cidade_id' => 4564,
                'nome'      => 'Umarizal'
            ],
            [
                'cidade_id' => 4564,
                'nome'      => 'Nazaré'
            ],
            [
                'cidade_id' => 4564,
                'nome'      => 'Reduto'
            ],
            [
                'cidade_id' => 4564,
                'nome'      => 'Marco'
            ],
            [
                'cidade_id' => 4564,
                'nome'      => 'Curió'
            ],
            [
                'cidade_id' => 4564,
                'nome'      => 'Terra Firme'
            ],
            [
                'cidade_id' => 4564,
                'nome'      => 'Jurunas'
            ],
            [
                'cidade_id' => 4564,
                'nome'      => 'Cremação'
            ],
            [
                'cidade_id' => 4564,
                'nome'      => 'Guanabara'
            ],
            [
                'cidade_id' => 4564,
                'nome'      => 'Sacramenta'
            ]
        ];


        Bairro::insert($bairros);

    }
}
