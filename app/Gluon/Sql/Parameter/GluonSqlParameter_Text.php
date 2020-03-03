<?php

namespace App\Gluon\Sql\Parameter;

use App\Gluon\GluonMap;
use DB;

use Schema;
use Illuminate\Database\Schema\Blueprint;

class GluonSqlParameter_Text  extends GluonSqlParameter_Abstract {

    public function createTable(){
        Schema::create('gluon_param_text', function (Blueprint $table) {
            $table->unsignedBigInteger('gluon_entity_id');
            $table->foreign('gluon_entity_id')->references('id')->on('gluon_entity');

            $table->string('key')->index();
            $table->text('value');

            $table->string('lang_code');
            $table->foreign('lang_code')->references('code')->on('lang');

            $table->softDeletes();
            $table->timestamps();
        });

    }


    public function processSave($entityId, $parameterKey, $value, $constraints=null){
        foreach ($value as $lang => $translatedValue) {
            DB::table('gluon_param_text')->updateOrInsert([
                'gluon_entity_id' => $entityId, 
                'key' => $parameterKey,
                'lang_code' => $lang
            ], [
                'value' => $translatedValue
            ]);
        }
    }



    public function buildQueryPart($query, $propertyKey, $queryData){
        $langs = ['fr', 'en'];
        $propertyType = 'text';

        $aliasPrefix = $queryData['aliasPrefix'];
        $referenceEntityId = $queryData['referenceEntityId'];

        foreach ($langs as $lang) {
            $valueAlias = "{$aliasPrefix}{$propertyType}__{$propertyKey}__{$lang}";
            $tableAlias = $valueAlias;

            $query->leftJoin("gluon_param_text as $tableAlias", function ($join) use ($tableAlias, $propertyKey, $lang, $referenceEntityId) {
                $join->on("$tableAlias.gluon_entity_id", '=', $referenceEntityId);
                $join->where("$tableAlias.lang_code", '=', $lang);
                $join->where("$tableAlias.key", '=', $propertyKey);
            });

            $query->addSelect("$tableAlias.value as $valueAlias");

        }
    }



    public function makeValueMap() {
        $defaultLang = "fr"; //@todo app.lang !

        $valueMap = new GluonMap();
        $valueMap->setDefaultKey($defaultLang);

        return $valueMap;

    }

    public  function hydrateValue($line, $entity, $key, $value, $additionalKey){
        $valueMap = $entity->getValue($key);

        if (! $valueMap){
            $valueMap = $this->makeValueMap();
            $entity->set('text', $key, $valueMap);
        }

        $valueMap->set($additionalKey, $value);

    }

}
