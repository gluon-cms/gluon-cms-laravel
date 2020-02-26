<?php

namespace App\Gluon\Sql;

use App\Gluon\GluonEntityResult;
use App\Gluon\GluonCollapsableValue;

use Debugbar;

class GluonSqlHydrator
{




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



    public function hydrateList($template, $lines){
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

                list($propertyType, $propertyKey) = explode('__', $propertyName);
                $value = $propertyType == 'text' ? new GluonCollapsableValue($propertyValue) : $propertyValue;
                $entity->set($propertyType, $propertyKey, $value);
            }

            /*
            //loop on related__*
            if (! isset($entity->related__associated)){
                $entity->related__associated = [];
            }

            if ($line->related__associated__id) {
                $relatedAssociatedEntity = getOrCreateEntity($line->related__associated__id, 'type!!', $relatedEntitiesById);

                $entity->related__associated[] = $relatedAssociatedEntity;

                //loop on related__associated__* properties
                $relatedAssociatedEntity->text__title = $line->related__associated__text__title;
            }*/
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
