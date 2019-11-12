<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'identification' => '1118657903',
                'name' => 'Rafael Hernández',
                'email' => 'rahernandezgarcia@gmail.com',
                'password' => bcrypt('admin'),
                'role' => 'admin'
            ]
        );

        DB::table('users')->insert(
            [
                'identification' => '1118565903',
                'name' => 'Dayron Campos',
                'email' => 'dayron321@hotmail.com',
                'password' => bcrypt('admin'),
                'role' => 'admin'
            ]
        );

        DB::table('users')->insert(
            [
                'identification' => '48657903',
                'name' => 'Oscar Martinez',
                'email' => 'oscar@hotmail.com',
                'password' => bcrypt('user'),
                'role' => 'user',
                'dependencia' => 'Aseguramiento'
            ]
        );

        DB::table('users')->insert(
            [
                'identification' => '1118562580',
                'name' => 'Jorge Hernández',
                'email' => 'joredher@hotmail.com',
                'password' => bcrypt('agent'),
                'role' => 'agent'
            ]
        );
    }
}
