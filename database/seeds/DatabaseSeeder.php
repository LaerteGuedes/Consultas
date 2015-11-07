<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

//        $this->call(RoleTableSeeder::class);
//        $this->call(UserTableSeeder::class);
//        $this->call(EspecialidadeTableSeeder::class);
//        $this->call(RamoTableSeeder::class);
//        $this->call(EstadoTableSeeder::class);
//        $this->call(CidadeTableSeeder::class);
//        $this->call(BairroTableSeeder::class);
//        $this->call(PlanoSeeder::class);

        Model::reguard();
    }
}
