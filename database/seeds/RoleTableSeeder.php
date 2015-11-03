<?php


use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder{

    public function run()
    {

        if (App::environment() === 'production') {
            exit('I just stopped you getting fired. Love, Amo.');
        }

        DB::table('roles')->truncate();



        Role::create([
            'id'            => 1,
            'name'          => 'Administrador',
            'description'   => 'Full access to create, edit, and update companies, and orders.'
        ]);

        Role::create([
            'id'            => 2,
            'name'          => 'Cliente',
            'description'   => 'Ability to create new companies and orders, or edit and update any existing ones.'
        ]);

        Role::create([
            'id'            => 3,
            'name'          => 'Profissional',
            'description'   => 'Able to manage the company that the user belongs to, including adding sites, creating new users and assigning licences.'
        ]);

        Role::create([
            'id'            => 4,
            'name'          => 'Colaborador',
            'description'   => 'A standard user that can have a licence assigned to them. No administrative features.'
        ]);
    }

}