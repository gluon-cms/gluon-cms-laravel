<?php

namespace App\Gluon\Sql\Parameter;

use App\Gluon\GluonMap;
use DB;
use Schema;
use Illuminate\Database\Schema\Blueprint;


class GluonSqlParameter_RelationOne  {

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


    public function processSave($entityId, $parameterKey, $value){
        /*DB::table('gluon_param_number')->updateOrInsert([
            'gluon_entity_id' => $entityId, 
            'key' => $parameterKey
        ], [
            'value' => $value
        ]);*/
    }

    public function buildQueryPart($query, $propertyKey){

        $propertyType = "relationOne";
        $tableAlias = "{$propertyType}__{$propertyKey}";
        $columnAlias = "{$propertyType}__{$propertyKey}__entity_id";

        if (in_array("$tableAlias.related_entity_id as $columnAlias", $query->columns)) {
            return;
        }
        

        $query->addSelect("$tableAlias.related_entity_id as $columnAlias");

        $query->leftJoin("gluon_param_relation_one as $tableAlias", function ($join) use ($tableAlias, $propertyKey) {
            $join->on("$tableAlias.gluon_entity_id", '=', 'gluon_entity.id');
            $join->where("$tableAlias.key", '=', $propertyKey);
        });
    }

    public function makeValueMap() {

        $valueMap = new GluonMap();
        $valueMap->setDefaultKey("default");

        return $valueMap;

    }

}
