<?php

use Illuminate\Database\Seeder;

use App\Estado;

class EstadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estados')->truncate();


        $estados = [

            [
                'uf' => 'AC',
                'nome'  => 'acre',
            ],
            [
                'uf' => 'AL',
                'nome'  => 'alagoas',
            ],
            [
                'uf' => 'AM',
                'nome'  => 'amazonas',
            ],
            [
                'uf' => 'AP',
                'nome'  => 'amapá',
            ],
            [
                'uf' => 'BA',
                'nome'  => 'bahia',
            ],
            [
                'uf' => 'CE',
                'nome'  => 'ceará',
            ],
            [
                'uf' => 'DF',
                'nome'  => 'distrito federal',
            ],
            [
                'uf' => 'ES',
                'nome'  => 'espírito santo',
            ],
            [
                'uf' => 'GO',
                'nome'  => 'goiás',
            ],
            [
                'uf' => 'MA',
                'nome'  => 'maranhão',
            ],
            [
                'uf' => 'MG',
                'nome'  => 'minas gerais',
            ],
            [
                'uf' => 'MS',
                'nome'  => 'mato grosso do sul',
            ],
            [
                'uf' => 'MT',
                'nome'  => 'mato grosso',
            ],
            [
                'uf' => 'PA',
                'nome'  => 'pará',
            ],
            [
                'uf' => 'PB',
                'nome'  => 'paraíba',
            ],
            [
                'uf' => 'PE',
                'nome'  => 'pernambuco',
            ],
            [
                'uf' => 'PI',
                'nome'  => 'piauí',
            ],
            [
                'uf' => 'PR',
                'nome'  => 'paraná',
            ],
            [
                'uf' => 'RJ',
                'nome'  => 'rio de janeiro',
            ],
            [
                'uf' => 'RN',
                'nome'  => 'rio grande do norte',
            ],
            [
                'uf' => 'RO',
                'nome'  => 'rôndonia',
            ],
            [
                'uf' => 'RR',
                'nome'  => 'roraima',
            ],
            [
                'uf' => 'RS',
                'nome'  => 'rio grande do sul',
            ],
            [
                'uf' => 'SC',
                'nome'  => 'santa catarina',
            ],
            [
                'uf' => 'SE',
                'nome'  => 'segipe',
            ],
            [
                'uf' => 'SP',
                'nome'  => 'são paulo',
            ],
            [
                'uf' => 'TO',
                'nome'  => 'tocantins',
            ],


        ];

        foreach($estados as $estado)
        {
            Estado::create($estado);
        }
    }
}
