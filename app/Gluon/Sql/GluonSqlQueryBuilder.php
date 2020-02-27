<?php

namespace App\Gluon\Sql;
use Illuminate\Support\Facades\DB;
use Debugbar;

class GluonSqlQueryBuilder
{

    protected $gluon;

    public function __construct(GluonSql $gluon) {
        $this->gluon = $gluon;
    }

    public function buildAndGet($template, $conditions = []) {
        $query = $this->build($template, $conditions);

        Debugbar::startMeasure('gluon-get-query', 'Gluon: execute query');
        $result = $query->get();
        Debugbar::stopMeasure('gluon-get-query');

        return $result;
    }

    public function build($template, $conditions = []) {
        Debugbar::startMeasure('gluon-build-query', 'Gluon: build query');

        $query = DB::table('gluon_entity');
        $query->select([
            'gluon_entity.id as entity_id',
            'gluon_entity.type as entity_type'
            //dates?
        ]);

        if($conditions){
            foreach ($conditions as $condition) {
                //check condition size... + replace .--> __?
                $query->where($condition[0], $condition[1], $condition[2]);
            }
        }

        foreach ($template as $key => $value) {
            list($propertyType, $propertyKey) = explode('.', $value);
            $this->gluon->getParameterHelper($propertyType)->buildQueryPart($query, $propertyKey);
        }

        Debugbar::stopMeasure('gluon-build-query');
        return $query;
    }
}
