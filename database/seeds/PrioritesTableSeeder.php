<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorits = ['Bajo','Normal','Alto','Urgente'];

        foreach ($priorits as $priorit) {
            DB::table('priorites')->insert(['nom' => $priorit]);
        }
    }
}
