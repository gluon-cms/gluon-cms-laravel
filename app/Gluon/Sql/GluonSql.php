<?php

namespace App\Gluon\Sql;


class GluonSql {

    protected $queryBuilder;

    public function __construct(){
        $this->queryBuilder = new GluonSqlQueryBuilder();
    }

    public function getOne($condition) { 
        $template = ['text.title', 'text.content', 'number.score'] ;
        //$template = ['text.title', 'text.content', 'related.associated.text.title']

        $conditions = [
            ['gluon_entity.id', '=', $condition]
        ];

        $lines = $this->queryBuilder->build($template, $conditions)->get();

        $hydrator = new GluonSqlHydrator();
        return $hydrator->hydrateOne($template, $lines);
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
