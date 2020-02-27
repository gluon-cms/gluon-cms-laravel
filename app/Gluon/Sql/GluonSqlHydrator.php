<?php

namespace App\Gluon\Sql;

use App\Gluon\GluonEntityResult;
use App\Gluon\GluonMap;

use Debugbar;

class GluonSqlHydrator
{

    protected $gluon;

    public function __construct(GluonSql $gluon) {
        $this->gluon = $gluon;
    }

    function getOrCreateEntity($id, $type, &$entitiesById, &$entities = []) {

        $entity = null;

        if(! isset($entitiesById[ $id ])) {
            $entitiesById[ $id ] = new GluonEntityResult($type, $id);
            $entity = $entitiesById[ $id ];

            $entities[] = $entity;
        } else {
            $entity = $entitiesById[ $id ];
        }

        $entity->id = $id;
        return $entity;
    }

    protected function propertySplit($propertyName){
        $parts = ['type', 'key', 'valueKey'];
        $splitted = explode('__', $propertyName);
        $splitted = array_pad($splitted, count($parts), "default");

        return array_combine($parts, $splitted);
    }


    public function hydrateList($template, $lines){
        $defaultLang = 'fr';
        Debugbar::startMeasure('gluon-hydrate-list', 'Gluon: hydrate list');

        $mainEntitiesById = [];
        $relatedEntitiesById = [];

        $entities = [];

        foreach ($lines as $line) {
            $entity = $this->getOrCreateEntity($line->entity_id, $line->entity_type, $mainEntitiesById, $entities);

            //properties
            foreach ($line as $propertyName => $propertyValue) {
                if ($propertyName == 'entity_id' || $propertyName == 'entity_type') {
                    continue;
                }

                $property = $this->propertySplit($propertyName);
                $valueMap = $entity->getValue($property['key']);

                if (! $valueMap){
                    $valueMap = $this->gluon->getParameterHelper($property['type'])->makeValueMap($property['key']);
                    $entity->set($property['type'], $property['key'], $valueMap);
                } 

                $valueMap->set($property['valueKey'], $propertyValue);

            }


        }

        Debugbar::stopMeasure('gluon-hydrate-list');
        return $entities;
    }

    public function hydrateOne($template, $lines){
        $entities = $this->hydrateList($template, $lines);

        if (count($entities) == 0){
            return null;
        }

        return $entities[0];
    }

}
