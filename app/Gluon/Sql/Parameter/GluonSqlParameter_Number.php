<?php

namespace App\Gluon\Sql\Parameter;
use DB;

class GluonSqlParameter_Number  {

    public function processSave($entityId, $parameterKey, $value){
        DB::table('gluon_param_number')->updateOrInsert([
            'gluon_entity_id' => $entityId, 
            'key' => $parameterKey
        ], [
            'value' => $value
        ]);
    }

}
