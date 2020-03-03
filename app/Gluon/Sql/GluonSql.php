<?php

namespace App\Gluon\Sql;

use Debugbar;
use DB;
use GluonConfig;

class GluonSql {

    protected $queryBuilder;
    protected $parameterHelper = [];

    public function __construct(){
        $this->queryBuilder = new GluonSqlQueryBuilder($this);

        $this->parameterHelper['text'] = new Parameter\GluonSqlParameter_Text($this);
        $this->parameterHelper['number'] = new Parameter\GluonSqlParameter_Number($this);
        $this->parameterHelper['relationOne'] = new Parameter\GluonSqlParameter_RelationOne($this);
        $this->parameterHelper['relationMany'] = new Parameter\GluonSqlParameter_RelationMany($this);

    }

    public function getOne($type, $id, $variant = null) {
        Debugbar::startMeasure('gluon-getone', 'Gluon: get One');

        $conditions = [
            ['gluon_entity.id', '=', $id]
        ];

        $template = GluonConfig::getTemplate($type, $variant);
        $lines = $this->queryBuilder->buildAndGet($template, $conditions);

        $hydrator = new GluonSqlHydrator($this);
        $result = $hydrator->hydrateOne($template, $lines);

        Debugbar::stopMeasure('gluon-getone');
        return $result;
        
    }

    public function getList($type, $variant = null) {
        Debugbar::startMeasure('gluon-getlist', 'Gluon: get list');

        $template = GluonConfig::getTemplate($type, $variant);

        $conditions = [
            ['gluon_entity.type', '=', $type]
        ];

        $lines = $this->queryBuilder->buildAndGet($template, $conditions);

        $hydrator = new GluonSqlHydrator($this);
        $result = $hydrator->hydrateList($template, $lines);

        Debugbar::stopMeasure('gluon-getlist');
        return $result;
    }

    public function getParameterHelper($type) {
        return $this->parameterHelper[$type];
    }

    public function save($entityId, $entityType, $parameters){
        $constraints = GluonConfig::getConstraints($parameters['type']);

        return DB::transaction(function() use($entityId, $parameters, $constraints) {
            foreach ($parameters as $parameter => $value) {

                if ($parameter == 'id' || $parameter == 'type') {
                    continue;
                }

                list($parameterType, $parameterKey) = explode(".", $parameter);
                $this->getParameterHelper($parameterType)->processSave(
                    $entityId, 
                    $parameterKey, 
                    $value, 
                    isset($constraints[$parameter]) ? $constraints[$parameter] : null
                );
            }
        });

    }

    public function count($template) {

    }

    public function countRelated($template) {

    }
}
