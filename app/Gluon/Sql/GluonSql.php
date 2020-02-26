<?php

namespace App\Gluon\Sql;

use Debugbar;

class GluonSql {

    protected $queryBuilder;

    public function __construct(){
        $this->queryBuilder = new GluonSqlQueryBuilder();
    }

    public function getOne($condition) {
        Debugbar::startMeasure('gluon-getone', 'Gluon: get One');

        $template = ['text.title', 'text.content', 'number.score'] ;
        //$template = ['text.title', 'text.content', 'related.associated.text.title']

        $conditions = [
            ['gluon_entity.id', '=', $condition]
        ];

        $lines = $this->queryBuilder->buildAndGet($template, $conditions);
        
        $hydrator = new GluonSqlHydrator();
        $result = $hydrator->hydrateOne($template, $lines);

        Debugbar::stopMeasure('gluon-getone');
        return $result;
        
    }

    public function getList($type) {
        Debugbar::startMeasure('gluon-getlist', 'Gluon: get list');

        $template = ['text.title', 'text.content', 'number.score'] ;
        //$template = ['text.title', 'text.content', 'related.associated.text.title']

        $conditions = [
            ['gluon_entity.type', '=', $type]
        ];

        $lines = $this->queryBuilder->buildAndGet($template, $conditions);

        $hydrator = new GluonSqlHydrator();
        $result = $hydrator->hydrateList($template, $lines);

        Debugbar::stopMeasure('gluon-getlist');
        return $result;
    }

    public function count($template) {

    }

    public function countRelated($template) {

    }
}
