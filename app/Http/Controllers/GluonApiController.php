<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GluonApiController extends Controller
{

    public function get($id) {

        //$description = ['text.title', 'text.content'] //+related


        $query = DB::table('gluon_entity');
        
        $query->select(['gluon_entity.id', 'text__title.value as title', 'text__content.value as content']);

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
