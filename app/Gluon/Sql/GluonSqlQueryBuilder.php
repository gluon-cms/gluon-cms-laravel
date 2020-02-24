<?php

namespace App\Gluon\Sql;
use Illuminate\Support\Facades\DB;


class GluonSqlQueryBuilder
{

    public function build($template, $conditions = []) {
        $lang = 'fr';

        $query = DB::table('gluon_entity');
        $query->select([
            'gluon_entity.id as entity_id',
            'gluon_entity.type as entity_type'
            //dates?
        ]);

        if($conditions){
            foreach ($conditions as $condition) {
                //check condition size... + replace .--> __?
                $query->where($condition[0], $condition[1], $condition[2]);
            }
        }

        foreach ($template as $key => $value) {
            list($propertyType, $propertyKey) = explode('.', $value);

            $tableAlias = str_replace('.', '__', $value); //+counter ?
            //$parameterAlias = "entity_$tableAlias";

            if ($propertyType == 'text') {
                $query->addSelect("$tableAlias.value as $tableAlias");

                $query->leftJoin("gluon_param_text as $tableAlias", function ($join) use ($tableAlias, $propertyKey, $lang) {
                    $join->on("$tableAlias.gluon_entity_id", '=', 'gluon_entity.id');
                    $join->where("$tableAlias.lang_code", '=', $lang);
                    $join->where("$tableAlias.key", '=', $propertyKey);
                });
            }

            if ($propertyType == 'number') {
                $query->addSelect("$tableAlias.value as $tableAlias");

                $query->leftJoin("gluon_param_number as $tableAlias", function ($join) use ($tableAlias, $propertyKey, $lang) {
                    $join->on("$tableAlias.gluon_entity_id", '=', 'gluon_entity.id');
                    $join->where("$tableAlias.key", '=', $propertyKey);
                });
            }

        }





        /*



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
*/

        //$query->where('gluon_entity.id', $id);
        //$query->orderBy('entity_id');
        //$query->orderBy('entity__text__title', 'DESC');

        //$query->orderBy('entity__text__title');
        //$query->orderBy('related__associated__rank'); //all ranks here !
        
        return $query;
    }
}
