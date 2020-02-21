<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GluonApiController extends Controller
{

    public function get($id) {

        //$description = ['text.title', 'text.content'] 
        //$description = ['text.title', 'text.content', 'related.associated.text.title']


        $query = DB::table('gluon_entity');
        
        $query->select([
            'gluon_entity.id as entity_id', 
            'text__title.value as text__title', 
            'text__content.value as text__content',

            'related__associated.related_entity_id as associated__id',
            'related__associated__text__title.value as associated__text__title',
        ]);

        $query->leftJoin('gluon_param_text as text__title', function ($join) {
            $join->on('text__title.gluon_entity_id', '=', 'gluon_entity.id');
            $join->where('text__title.lang_code', '=', 'fr');
            $join->where('text__title.key', '=', 'title');
        });

        $query->leftJoin('gluon_param_text as text__content', function ($join) {
            $join->on('text__content.gluon_entity_id', '=', 'gluon_entity.id');
            $join->where('text__content.lang_code', '=', 'fr');
            $join->where('text__content.key', '=', 'content');
        });

        //related
        $query->leftJoin('gluon_param_related as related__associated', function ($join) {
            $join->on('related__associated.gluon_entity_id', '=', 'gluon_entity.id');
            $join->where('related__associated.key', '=', 'associated');
        });

        $query->leftJoin('gluon_param_text as related__associated__text__title', function ($join) {
            $join->on('related__associated__text__title.gluon_entity_id', '=', 'related__associated.related_entity_id');
            $join->where('related__associated__text__title.lang_code', '=', 'fr');
            $join->where('related__associated__text__title.key', '=', 'title');
        });


        $query->where('gluon_entity.id', $id);

        $entities = $query->get();
        dd($entities);

        return response()->json([
            'name' => 'Abigail',
            'state' => 'CA'
        ]);
    }

    public function list($type) {
        return response()->json([
            'name' => 'Abigail',
            'state' => 'CA'
        ]);
    }
}
