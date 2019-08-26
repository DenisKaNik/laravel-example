<?php

use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'id' => 1,
                'name' => 'Home',
                'description' => 'Test description for home page',
            ],

            [
                'id' => 2,
                'name' => 'Page Anketa A',
                'description' => 'Test description for page anketa A',
            ],

            [
                'id' => 3,
                'name' => 'Page Anketa B',
                'description' => 'Test description for page anketa B',
            ]
        ];

        foreach ($pages as $page) {
            $model = new \App\Page($page);
            $model->save();
        }
    }
}
