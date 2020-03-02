<?php

namespace App\Gluon\Sql\Parameter;

use App\Gluon\GluonMap;
use DB;

use Schema;
use Illuminate\Database\Schema\Blueprint;

class GluonSqlParameter_Text  {

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


    public function processSave($entityId, $parameterKey, $value, $constraints){
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



    public function buildQueryPart($query, $propertyKey, $referenceEntityColumn = 'gluon_entity.id', $aliasPrefix = ''){
        $langs = ['fr', 'en'];
        $propertyType = 'text';

        foreach ($langs as $lang) {
            $tableAlias = "{$aliasPrefix}{$propertyType}__{$propertyKey}__{$lang}";
            $query->addSelect("$tableAlias.value as $tableAlias");

            $query->leftJoin("gluon_param_text as $tableAlias", function ($join) use ($tableAlias, $propertyKey, $lang, $referenceEntityColumn) {
                $join->on("$tableAlias.gluon_entity_id", '=', $referenceEntityColumn);
                $join->where("$tableAlias.lang_code", '=', $lang);
                $join->where("$tableAlias.key", '=', $propertyKey);
            });

        }
    }



    public function makeValueMap() {
        $defaultLang = "fr";

        $valueMap = new GluonMap();
        $valueMap->setDefaultKey($defaultLang);

        return $valueMap;

    }

}
