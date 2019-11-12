<?php

use App\Categories;
use App\CategoriesUser;
use Illuminate\Database\Seeder;

class CategoriesUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Categories::all();

        foreach ($categories as $category) {
            CategoriesUser::create([
                'user_id' => 4,
                'categorie_id' => $category->id
            ]);
        }
    }
}
