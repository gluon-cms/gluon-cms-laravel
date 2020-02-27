<?php

namespace App\Gluon\Sql;

use Debugbar;
use DB;

class GluonSql {

    protected $queryBuilder;
    protected $parameterHelper = [];

    public function __construct(){
        $this->queryBuilder = new GluonSqlQueryBuilder();

        $this->parameterHelper['text'] = new Parameter\GluonSqlParameter_Text();
        $this->parameterHelper['number'] = new Parameter\GluonSqlParameter_Number();
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

    public function save($entityId, $parameters){

        return DB::transaction(function() use($entityId, $parameters) {
            foreach ($parameters as $parameter => $value) {

                if ($parameter == 'id' || $parameter == 'type') {
                    continue;
                }

                list($parameterType, $parameterKey) = explode(".", $parameter);
                $this->parameterHelper[$parameterType]->processSave($entityId, $parameterKey, $value);
            }
        });

    }

    public function count($template) {

    }

    public function countRelated($template) {

    }
}
