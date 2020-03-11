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


        //categories
        DB::table('gluon_entity')->insert([
            'id' => 4,
            'type' => 'category',
        ]);

        DB::table('gluon_entity')->insert([
            'id' => 5,
            'type' => 'category',
        ]);

        DB::table('gluon_entity')->insert([
            'id' => 6,
            'type' => 'category',
        ]);

        DB::table('gluon_entity')->insert([
            'id' => 7,
            'type' => 'category',
        ]);

        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 4,
            'key' => 'label',
            'lang_code' => 'fr',
            'value' => 'Théatre'
        ]);


        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 4,
            'key' => 'label',
            'lang_code' => 'en',
            'value' => 'Play'
        ]);

        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 5,
            'key' => 'label',
            'lang_code' => 'fr',
            'value' => 'Spectacle'
        ]);


        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 5,
            'key' => 'label',
            'lang_code' => 'en',
            'value' => 'Show'
        ]);

        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 6,
            'key' => 'label',
            'lang_code' => 'fr',
            'value' => 'Jeune public'
        ]);


        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 6,
            'key' => 'label',
            'lang_code' => 'en',
            'value' => 'Young people'
        ]);

        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 7,
            'key' => 'label',
            'lang_code' => 'fr',
            'value' => 'Test'
        ]);


        DB::table('gluon_param_text')->insert([
            'gluon_entity_id' => 7,
            'key' => 'label',
            'lang_code' => 'en',
            'value' => 'Test'
        ]);

        //RELATIONS

        
        DB::table('gluon_param_relation_many')->insert([
            'gluon_entity_id' => 1,
            'key' => 'categories',
            'rank' => 1,
            'related_entity_id' => 4,
        ]);

        DB::table('gluon_param_relation_many')->insert([
            'gluon_entity_id' => 1,
            'key' => 'categories',
            'rank' => 2,
            'related_entity_id' => 5,
        ]);

        DB::table('gluon_param_relation_many')->insert([
            'gluon_entity_id' => 1,
            'key' => 'categories',
            'rank' => 3,
            'related_entity_id' => 6,
        ]);

        DB::table('gluon_param_relation_many')->insert([
            'gluon_entity_id' => 1,
            'key' => 'categories',
            'rank' => 4,
            'related_entity_id' => 7,
        ]);

        DB::table('gluon_param_relation_many')->insert([
            'gluon_entity_id' => 2,
            'key' => 'categories',
            'rank' => 1,
            'related_entity_id' => 5,
        ]);
    }
}
