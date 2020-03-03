<?php

namespace App\Gluon\Sql\Parameter;

use App\Gluon\GluonMap;
use App\Gluon\Sql\GluonSql;

use DB;
use Schema;
use Illuminate\Database\Schema\Blueprint;


abstract class GluonSqlParameter_Abstract  {

    protected $gluon;

    public function __construct(GluonSql $gluon){
        $this->gluon = $gluon;
    }

    abstract public function createTable();
    abstract public function processSave($entityId, $parameterKey, $value, $constraints=null);
    abstract public  function buildQueryPart($query, $propertyKey, $queryData);
    abstract public  function hydrateValue($line, $entity, $key, $value, $additionalKey, $prefix);



}
