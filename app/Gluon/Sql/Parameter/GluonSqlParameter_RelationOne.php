<?php

namespace App\Gluon\Sql\Parameter;

use App\Gluon\GluonMap;
use DB;
use Schema;
use Illuminate\Database\Schema\Blueprint;


class GluonSqlParameter_RelationOne  extends GluonSqlParameter_RelationAbstract {

    public function createTable(){
        Schema::create('gluon_param_relation_one', function (Blueprint $table) {
            $table->unsignedBigInteger('gluon_entity_id');
            $table->foreign('gluon_entity_id')->references('id')->on('gluon_entity');

            $table->string('key')->index();

            $table->unsignedBigInteger('related_entity_id');
            $table->foreign('related_entity_id')->references('id')->on('gluon_entity');

            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function processSave($entityId, $parameterKey, $value, $constraints=null){

        //@todo handle array or scalar for $value

        DB::table('gluon_param_relation_one')->updateOrInsert([
            'gluon_entity_id' => $entityId, 
            'key' => $parameterKey
        ], [
            'related_entity_id' => $value
        ]);

        if ($constraints && $constraints['reverse']) {
            list($reverseType, $reverseParameter) = explode(".", $constraints['reverse']);
            $this->gluon->getParameterHelper($reverseType)->processSave($value, $reverseParameter, $entityId);
        }

    }

    public function buildQueryPart($query, $propertyKey, $referenceEntityColumn = 'gluon_entity.id', $aliasPrefix = ''){

        $propertyType = "relationOne";
        $tableAlias = "{$propertyType}__{$propertyKey}";
        $columnIdAlias = "{$propertyType}__{$propertyKey}__entity_id";
        

        if (in_array("$tableAlias.related_entity_id as $columnIdAlias", $query->columns)) {
            return;
        }

        $query->addSelect("$tableAlias.related_entity_id as $columnIdAlias");

        $query->leftJoin("gluon_param_relation_one as $tableAlias", function ($join) use ($tableAlias, $propertyKey) {
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
