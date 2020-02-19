<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                   => 1,
                'name'                 => 'Admin',
                'email'                => 'admin@admin.com',
                'password'             => '$2y$10$4zmF5JonP/hmV5WrEBrr8e2uRUk/Vf1N3uD3M4gD4wjmsEj6DoH.K',
                'remember_token'       => null,
                'identifiant_fiscal'   => '',
                'registre_commerce'    => '',
                'taxe_professionnelle' => '',
                'cnss'                 => '',
                'ice'                  => '',
                'nom_gerant'           => '',
                'cin'                  => '',
                'phone'                => '',
                'num_fix'              => '',
            ],
        ];

        User::insert($users);
    }
}
