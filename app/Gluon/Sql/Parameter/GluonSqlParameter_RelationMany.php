<?php

namespace App\Gluon\Sql\Parameter;

use App\Gluon\GluonMap;
use DB;
use Schema;
use Illuminate\Database\Schema\Blueprint;


class GluonSqlParameter_RelationMany  {

    public function createTable(){
        Schema::create('gluon_param_relation_many', function (Blueprint $table) {
            $table->unsignedBigInteger('gluon_entity_id');
            $table->foreign('gluon_entity_id')->references('id')->on('gluon_entity');

            $table->string('key')->index();
            $table->integer('rank')->default(1)->index();

            $table->unsignedBigInteger('related_entity_id');
            $table->foreign('related_entity_id')->references('id')->on('gluon_entity');

            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function processSave($entityId, $parameterKey, $value){

        DB::table('gluon_param_relation_many')->where([
            ['gluon_entity_id', $entityId],
            ['key', $parameterKey]
        ])->delete();

        foreach ($value as $related) {
            DB::table('gluon_param_relation_many')->insert([
                'gluon_entity_id' => $entityId, 
                'key' => $parameterKey,
                'related_entity_id' => $related["id"],
                'rank' => $related["rank"]
            ]);
        }

    }

    public function buildQueryPart($query, $propertyKey){

        $propertyType = "relationMany";
        $tableAlias = "{$propertyType}__{$propertyKey}";
        $columnIdAlias = "{$propertyType}__{$propertyKey}__entity_id";
        $columnRankAlias = "{$propertyType}__{$propertyKey}__rank";

        if (in_array("$tableAlias.related_entity_id as $columnIdAlias", $query->columns)) {
            return;
        }

        $query->addSelect("$tableAlias.related_entity_id as $columnIdAlias");
        $query->addSelect("$tableAlias.rank as $columnRankAlias");

        $query->orderby("$columnRankAlias");

        $query->leftJoin("gluon_param_relation_many as $tableAlias", function ($join) use ($tableAlias, $propertyKey) {
            $join->on("$tableAlias.gluon_entity_id", '=', 'gluon_entity.id');
            $join->where("$tableAlias.key", '=', $propertyKey);
        });

        //

        $baseTableAlias = "{$propertyType}__{$propertyKey}__baseEntity";
        $columnTypeAlias = "{$propertyType}__{$propertyKey}__entity_type";
        $referenceId = "$tableAlias.related_entity_id";

        $query->addSelect("$baseTableAlias.type as $columnTypeAlias");

        $query->leftJoin("gluon_entity as $baseTableAlias", function ($join) use ($baseTableAlias, $referenceId) {
            $join->on("$baseTableAlias.id", '=', $referenceId);
        });
    }

    public function makeValueMap() {

        $valueMap = new GluonMap();
        $valueMap->setDefaultKey("default");

        return $valueMap;

    }

}
