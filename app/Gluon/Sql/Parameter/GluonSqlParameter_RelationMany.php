<?php

namespace App\Gluon\Sql\Parameter;

use App\Gluon\GluonMap;
use DB;
use Schema;
use Illuminate\Database\Schema\Blueprint;


class GluonSqlParameter_RelationMany  extends GluonSqlParameter_RelationAbstract {

    public function getType(){
        return 'relationMany';
    }

    public function getTable(){
        return 'gluon_param_relation_many';
    }


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


    public function processSave($entityId, $parameterKey, $value, $constraints=null){

        //@todo handle array or scalar for $value
        //@todo handle append?

        DB::table('gluon_param_relation_many')->where([
            ['gluon_entity_id', $entityId],
            ['key', $parameterKey]
        ])->delete();

        foreach ($value as $related) {
            if (! isset($related["id"]) || !$related["id"]) {
                continue;
            }

            DB::table('gluon_param_relation_many')->insert([
                'gluon_entity_id' => $entityId, 
                'key' => $parameterKey,
                'related_entity_id' => $related["id"],
                'rank' => isset($related["rank"]) ? $related["rank"] : 1
            ]);
        }

        //handle reverse.
    }


    public function makeValueMap() {

        $valueMap = new GluonMap();
        $valueMap->setDefaultKey("default");

        return $valueMap;

    }

}
