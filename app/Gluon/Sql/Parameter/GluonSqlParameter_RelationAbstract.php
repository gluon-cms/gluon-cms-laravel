<?php

namespace App\Gluon\Sql\Parameter;

use App\Gluon\GluonMap;
use App\Gluon\GluonEntityResult;

use DB;
use Schema;
use Illuminate\Database\Schema\Blueprint;


abstract class GluonSqlParameter_RelationAbstract  extends GluonSqlParameter_Abstract {
    abstract public function getType();

    protected $relatedEntities = [];

    public function propertySplit($propertyName, $separator="__"){
        $parts = ['type', 'key', 'more'];
        $splitted = explode($separator, $propertyName, 3);
        $splitted = array_pad($splitted, count($parts), null);

        return array_combine($parts, $splitted);
    }


    protected function buildRelatedEntityQueryPart($query, $propertyKey, $additionalKey, $referenceEntity, $prefixForAliases){
        $type = $this->getType();

        $relatedProperty = $this->propertySplit($additionalKey, ".");
        
        $referenceEntity = "{$type}__{$propertyKey}.related_entity_id";
        $prefixForAliases = "{$type}__{$propertyKey}__";

        $this->gluon->getParameterHelper($relatedProperty['type'])->buildQueryPart(
            $query, 
            $relatedProperty['key'], 
            $relatedProperty['more'], 
            $referenceEntity, 
            $prefixForAliases
        );

    }



    public  function hydrateValue($line, $entity, $key, $value, $additionalKey){
        $type = $this->getType();

        $relatedEntityIdKey = "{$type}__{$key}__entity_id";
        $relatedEntityTypeKey = "{$type}__{$key}__entity_type";

        $relatedEntityId = $line->$relatedEntityIdKey;
        $relatedEntityType = $line->$relatedEntityTypeKey;

        if ($additionalKey == "entity_id"){
            $relatedEntity = new GluonEntityResult($relatedEntityType, $value);
            $this->relatedEntities[ $value ] = $relatedEntity;

            if ($type == "relationMany"){
                $existingMany = $entity->getValue($key);
                if (!$existingMany) {
                    $existingMany = [];
                }

                $existingMany[] = $relatedEntity;
                $entity->set($type, $key, $existingMany);
                return;
            } 

            if ($type == "relationOne") {
                $entity->set($this->getType(), $key, $relatedEntity);
                return;
            }

            return;
        }

        $subProperty = $this->propertySplit($additionalKey);

        if ($subProperty["key"]==null){ //not a subkey
            return;
        }

        $relatedEntity = $this->relatedEntities[ $relatedEntityId ];

        $this->gluon->getParameterHelper($subProperty['type'])->hydrateValue(
            $line, 
            $relatedEntity, 
            $subProperty['key'], 
            $value,
            $subProperty['more']
        );

    }
}
