<?php

namespace App\Gluon\Sql\Parameter;

use App\Gluon\GluonMap;
use DB;
use Schema;
use Illuminate\Database\Schema\Blueprint;


class GluonSqlParameter_RelationOne  extends GluonSqlParameter_RelationAbstract {

    public function getType(){
        return 'relationOne';
    }

    public function getTable(){
        return 'gluon_param_relation_one';
    }

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

    

    public function makeValueMap() {

        $valueMap = new GluonMap();
        $valueMap->setDefaultKey("default");

        return $valueMap;

    }

}
