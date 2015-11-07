<?php

use App\Plano;
use Illuminate\Database\Seeder;

class PlanoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $planos = [
            ["titulo" => "Hapvida"],
            ['titulo' => 'Hapvida Enfermaria'],
            ['titulo' => 'Hapvida Apartamento']
        ];

        foreach ($planos as $plano) {
            Plano::create($plano);
        }

    }
}
