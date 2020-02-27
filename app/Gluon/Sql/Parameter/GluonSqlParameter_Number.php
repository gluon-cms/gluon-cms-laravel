<?php

namespace App\Gluon\Sql\Parameter;

use App\Gluon\GluonMap;
use DB;
use Schema;
use Illuminate\Database\Schema\Blueprint;


class GluonSqlParameter_Number  {

    public function createTable(){
        Schema::create('gluon_param_number', function (Blueprint $table) {
            $table->unsignedBigInteger('gluon_entity_id');
            $table->foreign('gluon_entity_id')->references('id')->on('gluon_entity');

            $table->string('key')->index();
            $table->float('value')->index();

            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function processSave($entityId, $parameterKey, $value){
        DB::table('gluon_param_number')->updateOrInsert([
            'gluon_entity_id' => $entityId, 
            'key' => $parameterKey
        ], [
            'value' => $value
        ]);
    }

    public function buildQueryPart($query, $propertyKey){
        $propertyType = "number";
        $tableAlias = "{$propertyType}__{$propertyKey}";

        $query->addSelect("$tableAlias.value as $tableAlias");

        $query->leftJoin("gluon_param_number as $tableAlias", function ($join) use ($tableAlias, $propertyKey) {
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
