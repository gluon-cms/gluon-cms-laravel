<?php

namespace App\Gluon\Config;
use Config;

class GluonConfig
{

    public function getEntityTypeList(){
        $types = array_keys(Config::get("gluonEntities.definitions"));
        return $types;
    }

    public function getDefinition($type){
        $definitionRaw = Config::get("gluonEntities.definitions.$type");
        $definition = [];

        foreach ($definitionRaw as $property) {
            list($type, $key) = explode('.', $property);

            $definition[] = [
                'property' => $property,
                'type' => $type,
                'key' => $key,
            ];
        }

        return $definition;
    }

    public function getConstraints($type){
        $allConstraints = Config::get("gluonEntities.constraints");
        $contraintsForType = [];

        foreach ($allConstraints as $key => $value) {
            list($entityType, $parameter) = explode(".", $key, 2);

            if ($entityType != $type){
                continue;
            }

            $contraintsForType[$parameter] = $value;
        }

        return $contraintsForType;
    }

    public function getTemplate($type, $variant){

        $result = Config::get("gluonEntities.templates.{$type}--{$variant}");
        $result = $result ? $result : Config::get("gluonEntities.templates.{$type}");

        return $result;
    }


}

