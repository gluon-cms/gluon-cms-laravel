<?php

namespace App\Gluon\Sql;


class GluonSql {

    protected $queryBuilder;

    public function __construct(){
        $this->queryBuilder = new GluonSqlQueryBuilder();
    }

    public function getOne($type, $condition) { 
        $template = ['text.title', 'text.content', 'number.score'] ;
        //$template = ['text.title', 'text.content', 'related.associated.text.title']

        $lines = $this->queryBuilder->build($template)->get();

        $hydrator = new GluonSqlHydrator();
        return $hydrator->hydrateOne($lines);
    }

    public function getList($type) {
        $template = ['text.title', 'text.content', 'number.score'] ;
        //$template = ['text.title', 'text.content', 'related.associated.text.title']

        $conditions = [
            ['gluon_entity.type', '=', $type]
        ];

        $lines = $this->queryBuilder->build($template, $conditions)->get();

        $hydrator = new GluonSqlHydrator();
        return $hydrator->hydrateList($template, $lines);
    }

    public function count($template) {

    }

    public function countRelated($template) {

    }
}
