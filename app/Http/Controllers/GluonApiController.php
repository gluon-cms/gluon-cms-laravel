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
            'text__title.value as entity__text__title', 
            'text__content.value as entity__text__content',

            'related__associated.related_entity_id as related__associated__id',
            'related__associated.rank as related__associated__rank',
            'related__associated__text__title.value as related__associated__text__title',
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

        //related "associated"
        $query->leftJoin('gluon_param_related as related__associated', function ($join) {
            $join->on('related__associated.gluon_entity_id', '=', 'gluon_entity.id');
            $join->where('related__associated.key', '=', 'associated');
        });

        $query->leftJoin('gluon_param_text as related__associated__text__title', function ($join) {
            $join->on('related__associated__text__title.gluon_entity_id', '=', 'related__associated.related_entity_id');
            $join->where('related__associated__text__title.lang_code', '=', 'fr');
            $join->where('related__associated__text__title.key', '=', 'title');
        });


        //$query->where('gluon_entity.id', $id);
        //$query->orderBy('entity_id');
        //$query->orderBy('entity__text__title', 'DESC');

        $query->orderBy('entity__text__title');
        $query->orderBy('related__associated__rank'); //all ranks here !
        
        $lines = $query->get();


        $baseEntitiesById = [];
        $relatedEntitiesById = [];

        $entities = [];

        function getOrCreateEntity($id, &$entitiesById, &$entities = []) {

            $entity = null;

            if(! isset($entitiesById[ $id ])) {
                $entitiesById[ $id ] = new \stdClass(); //GluonEntityResult
                $entity = $entitiesById[ $id ];

                $entities[] = $entity;
            } else {
                $entity = $entitiesById[ $id ];
            }

            $entity->id = $id;
            return $entity;
        };


        foreach ($lines as $line) {
            $entity = getOrCreateEntity($line->entity_id, $baseEntitiesById, $entities);

            //(re)populate entity

            //loop on entity__* properties
            $entity->text__title = $line->entity__text__title;
            $entity->text__content = $line->entity__text__content;

            //loop on related__*
            if (! isset($entity->related__associated)){
                $entity->related__associated = [];
            }

            if ($line->related__associated__id) {
                $relatedAssociatedEntity = getOrCreateEntity($line->related__associated__id, $relatedEntitiesById);

                $entity->related__associated[] = $relatedAssociatedEntity;

                //loop on related__associated__* properties
                $relatedAssociatedEntity->text__title = $line->related__associated__text__title;
            }
        }

        
        return response()->json([
            'lines' => $lines,
            'entities' => $entities
        ]);
    }

    public function list($type) {
        return response()->json([
            'name' => 'Abigail',
            'state' => 'CA'
        ]);
    }
}
