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

    public function getSettings(){
        $settings = Config::get("gluonEntities.settings");
        return $settings;
    }

    public function getConstraints($type){
        $allConstraints = Config::get("gluonEntities.constraints");
        $contraintsForType = [];
        $contraintsForType["entity"] = [];

        foreach ($allConstraints as $key => $value) {
            $parts = explode(".", $key, 2);
            $entityType = isset($parts[0]) ? $parts[0] : null;
            $parameter = isset($parts[1]) ? $parts[1] : null;

            if ($entityType != $type){
                continue;
            }

            if (! $parameter) {
                $contraintsForType["entity"] = $value;
            }

            $contraintsForType[$parameter] = $value;
        }

        return $contraintsForType;
    }

    public function getTemplate($type, $variant){

        $preciseTemplate = Config::get("gluonEntities.templates.{$type}--{$variant}");

        if ($preciseTemplate){
            return $preciseTemplate;
        }

        $fallbackTemplate = Config::get("gluonEntities.templates.{$type}");

        if ($fallbackTemplate){
            return $fallbackTemplate;
        }

        $fallbackDefinition = Config::get("gluonEntities.definitions.{$type}");
        return $fallbackDefinition;
    }


}

