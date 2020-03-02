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
        $parts = ['type', 'key', 'more'];
        $splitted = explode('__', $propertyName, 3);
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
                $workEntity = $entity;

                if($property['type'] == "relationOne" || $property['type'] == "relationMany") {
                    
                    $relatedEntityTypeKey = "{$property['type']}__{$property['key']}__entity_type";
                    $reletedEntityType = $line->$relatedEntityTypeKey;

                    $relatedEntityIdKey = "{$property['type']}__{$property['key']}__entity_id";
                    $reletedEntityId = $line->$relatedEntityIdKey;

                    if ($property['more'] == "entity_id"){

                        $relatedEntity = $this->getOrCreateEntity($propertyValue, $reletedEntityType, $relatedEntitiesById); 

                        if ($property['type'] == "relationMany"){
                            $existingMany = $entity->getValue($property['key']);
                            if (!$existingMany) {
                                $existingMany = [];
                            }

                            $existingMany[] = $relatedEntity;
                            $entity->set($property['type'], $property['key'], $existingMany);
                        } else {
                            $entity->set($property['type'], $property['key'], $relatedEntity);
                        }

                        continue;
                    }

                    if ($property['more'] == "entity_type"){
                        continue;
                    }

                    if ($property['more'] == "rank"){
                        continue; //!!!!!
                    }

                    $relatedEntity = $this->getOrCreateEntity($reletedEntityId, $reletedEntityType, $relatedEntitiesById);
                    $subProperty = $this->propertySplit($property['more']);

                    $valueMap = $relatedEntity->getValue($subProperty['key']);

                    if (! $valueMap){
                        $valueMap = $this->gluon->getParameterHelper($subProperty['type'])->makeValueMap($subProperty['key']);
                        $relatedEntity->set($subProperty['type'], $subProperty['key'], $valueMap);
                    } 
                    
                    //@todo done by parameter helper...
                    $valueMap->set($subProperty['more'], $propertyValue);

                } else {

                    $this->gluon->getParameterHelper($property['type'])->hydrateValue(
                        $entity, 
                        $property['key'], 
                        $propertyValue,
                        $property['more']
                    );

                }

                
                

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
