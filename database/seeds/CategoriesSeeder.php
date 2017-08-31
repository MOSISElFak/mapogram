<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')
            ->insert([
                ['name' => '#nature'],
                ['name' => '#sport'],
                ['name' => '#fitness'],
                ['name' => '#history'],
                ['name' => '#people'],
                ['name' => '#love'],
                ['name' => '#macro'],
                ['name' => '#blackandwhite'],
                ['name' => '#cars'],
                ['name' => '#monuments'],
                ['name' => '#history'],
                ['name' => '#art'],
                ['name' => '#music'],
                ['name' => '#party'],
                ['name' => '#birthday'],
                ['name' => '#restaurant']
            ]);
    }
}
