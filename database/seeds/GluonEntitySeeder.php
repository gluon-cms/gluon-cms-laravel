<?php

use Illuminate\Database\Seeder;

class GluonEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gluon_entity')->insert([
            'id' => 1,
            'type' => 'article',
        ]);

        DB::table('gluon_entity')->insert([
            'id' => 2,
            'type' => 'article',
        ]);

        DB::table('gluon_entity')->insert([
            'id' => 3,
            'type' => 'article',
        ]);

        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 1,
            'key' => 'title',
            'lang_code' => 'fr',
            'value' => 'Ceci est un titre'
        ]);

        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 1,
            'key' => 'title',
            'lang_code' => 'en',
            'value' => 'This is a title'
        ]);

        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 1,
            'key' => 'content',
            'lang_code' => 'fr',
            'value' => 'Ceci est un contenu très long'
        ]);

        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 1,
            'key' => 'content',
            'lang_code' => 'en',
            'value' => 'This is a very long content'
        ]);

        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 2,
            'key' => 'title',
            'lang_code' => 'fr',
            'value' => 'Ceci est un autre titre'
        ]);

        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 2,
            'key' => 'title',
            'lang_code' => 'en',
            'value' => 'This is another title'
        ]);

        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 2,
            'key' => 'content',
            'lang_code' => 'fr',
            'value' => 'Ceci est un autre contenu très long'
        ]);

        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 2,
            'key' => 'content',
            'lang_code' => 'en',
            'value' => 'This is another very long content'
        ]);

        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 3,
            'key' => 'title',
            'lang_code' => 'fr',
            'value' => 'Ceci est un troisième titre'
        ]);

        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 3,
            'key' => 'title',
            'lang_code' => 'en',
            'value' => 'This is a third title'
        ]);


        //RELATIONS

        /*
        DB::table('gluon_param_related')->insert([
            'gluon_entity_id' => 1,
            'key' => 'associated',
            'rank' => 2,
            'related_entity_id' => 2,
        ]);

        DB::table('gluon_param_related')->insert([
            'gluon_entity_id' => 2,
            'key' => 'associated',
            'related_entity_id' => 1,
        ]);

        DB::table('gluon_param_related')->insert([
            'gluon_entity_id' => 1,
            'key' => 'associated',
            'rank' => 1,
            'related_entity_id' => 3,
        ]);*/
    }
}
