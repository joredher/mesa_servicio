<?php

use App\Categories;
use App\CategoriesUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priorits =
            [
                ['name' => 'Soporte Técnico','color' => '#6BA877']
                //['name' => 'Aseguramiento','color' => '#FFD866'],
                //['name' => 'Atención al Usuario','color' => '#4DBC9B'],
                //['name' => 'Facturación','color' => '#3B3B58']
            ];

        foreach ($priorits as $priorit) {
            DB::table('categories')->insert(
                [
                    'name' => $priorit['name'],
                    'color' => $priorit['color']
                ]);
        }
    }
}
