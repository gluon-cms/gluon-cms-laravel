<?php

use Illuminate\Database\Seeder;

class LangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lang')->insert([
            'code' => 'fr',
        ]);

        DB::table('lang')->insert([
            'code' => 'en',
        ]);
    }
}
