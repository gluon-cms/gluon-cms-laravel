<?php

namespace App\Gluon\Sql\Parameter;

use App\Gluon\GluonMap;
use DB;
use Schema;
use Illuminate\Database\Schema\Blueprint;


class GluonSqlParameter_Flag extends GluonSqlParameter_Abstract {

    public function createTable(){
        Schema::create('gluon_param_flag', function (Blueprint $table) {
            $table->unsignedBigInteger('gluon_entity_id');
            $table->foreign('gluon_entity_id')->references('id')->on('gluon_entity');

            $table->string('key')->index();
            $table->boolean('value')->index();

            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function processSave($entityId, $parameterKey, $value, $constraints=null){

        DB::table('gluon_param_flag')->updateOrInsert([
            'gluon_entity_id' => $entityId, 
            'key' => $parameterKey
        ], [
            'value' => $value
        ]);
    }

    public function buildQueryPart($query, $propertyKey, $queryData){
        $propertyType = "flag";
        $aliasPrefix = $queryData['aliasPrefix'];
        $referenceEntityId = $queryData['referenceEntityId'];

        $valueAlias = "{$aliasPrefix}{$propertyType}__{$propertyKey}";
        $tableAlias = $valueAlias;

        $query->leftJoin("gluon_param_flag as $tableAlias", function ($join) use ($tableAlias, $propertyKey, $referenceEntityId) {
            $join->on("$tableAlias.gluon_entity_id", '=', $referenceEntityId);
            $join->where("$tableAlias.key", '=', $propertyKey);
        });

        $query->addSelect("$tableAlias.value as $valueAlias");

    }

    public  function hydrateValue($line, $entity, $key, $value, $additionalKey, $prefix){
        $entity->set('flag', $key, $value);
    }

}
