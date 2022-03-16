<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Health', 'description' => 'Post about health'],
            ['name' => 'Finance', 'description' => 'Post about finance'],
            ['name' => 'Politics', 'description' => 'Post about politics'],
            ['name' => 'Education', 'description' => 'Post about education'],
            ['name' => 'Holidays', 'description' => 'Post about holidays'],
            ['name' => 'Hobby\'s', 'description' => 'Post about hobby\'s'],
            ['name' => 'Sports', 'description' => 'Post about sports'],
        ];

        foreach($categories as $category) {
            $newCategory = new Category();
            $newCategory->fill($category);
            $newCategory->save();
        }
    }
}
