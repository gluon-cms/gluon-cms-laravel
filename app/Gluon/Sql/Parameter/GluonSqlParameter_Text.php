<?php

namespace App\Gluon\Sql\Parameter;

use DB;

class GluonSqlParameter_Text  {

    public function processSave($entityId, $parameterKey, $value){
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

}
