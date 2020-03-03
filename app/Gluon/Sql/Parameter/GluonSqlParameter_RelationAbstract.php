<?php

namespace App\Gluon\Sql\Parameter;

use App\Gluon\GluonMap;
use App\Gluon\GluonEntityResult;

use DB;
use Schema;
use Illuminate\Database\Schema\Blueprint;


abstract class GluonSqlParameter_RelationAbstract  extends GluonSqlParameter_Abstract {
    abstract public function getType();
    abstract public function getTable();

    protected $relatedEntities = [];

    public function propertySplit($propertyName, $separator="__"){
        $parts = ['type', 'key', 'more'];
        $splitted = explode($separator, $propertyName, 3);
        $splitted = array_pad($splitted, count($parts), null);

        return array_combine($parts, $splitted);
    }


    public function buildQueryPart($query, $propertyKey, $queryData){
        $relatedEntityIdColumn = $this->buildQueryPart_RelatedIdAndType($query, $propertyKey, $queryData);

        $queryData['referenceEntityId'] = $relatedEntityIdColumn;
        $this->buildQueryPart_RelatedParameters($query, $propertyKey, $queryData);
    }

    protected function buildQueryPart_RelatedIdAndType($query, $propertyKey, $queryData){
        $propertyType = $this->getType();
        $table = $this->getTable();

        $aliasPrefix = $queryData['aliasPrefix'];
        $referenceEntityId = $queryData['referenceEntityId'];

        $tableAlias    = "{$aliasPrefix}{$propertyType}__{$propertyKey}";
        $columnIdAlias = "{$aliasPrefix}{$propertyType}__{$propertyKey}__entity_id";

        $relatedEntityId = "$tableAlias.related_entity_id"; //used as base for sub joins
        $selectRelatedId = "$relatedEntityId as $columnIdAlias";

        //already selected ? No need to select again.
        if (in_array($selectRelatedId, $query->columns)) {
            return $relatedEntityId;
        }

        //select related entity id...
        $query->leftJoin("$table as $tableAlias", function ($join) use ($tableAlias, $propertyKey, $referenceEntityId) {
            $join->on("$tableAlias.gluon_entity_id", '=', $referenceEntityId);
            $join->where("$tableAlias.key", '=', $propertyKey);
        });

        $query->addSelect($selectRelatedId);

        //select related rank if many
        if ($propertyType == 'relationMany') {
            $columnRankAlias = "{$aliasPrefix}{$propertyType}__{$propertyKey}__rank";
            $query->addSelect("$tableAlias.rank as $columnRankAlias");
            $query->orderby("$columnRankAlias");
        }

        //then related entity type (in the base gluon_entity table) ...
        $baseTableAlias = "{$aliasPrefix}{$propertyType}__{$propertyKey}__baseEntity";
        $columnTypeAlias = "{$aliasPrefix}{$propertyType}__{$propertyKey}__entity_type";

        $query->leftJoin("gluon_entity as $baseTableAlias", function ($join) use ($baseTableAlias, $relatedEntityId) {
            $join->on("$baseTableAlias.id", '=', $relatedEntityId);
        });

        $query->addSelect("$baseTableAlias.type as $columnTypeAlias");

        return $relatedEntityId;
    }



    protected function buildQueryPart_RelatedParameters($query, $propertyKey, $queryData){
        $type = $this->getType();

        $additionalKey = $queryData['propertyMore'];
        $relatedProperty = $this->propertySplit($additionalKey, ".");

        $referenceEntity = $queryData['referenceEntityId'];
        $queryData['propertyMore'] = $relatedProperty['more'];
        $queryData['aliasPrefix'] .= "{$type}__{$propertyKey}__";

        $this->gluon->getParameterHelper($relatedProperty['type'])->buildQueryPart(
            $query, 
            $relatedProperty['key'], 
            $queryData
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
