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
        $definition = Config::get("gluonEntities.definitions.$type");
        return $this->completeDefinition($definition);
    }

    public function completeDefinition($definition){
        array_unshift($definition, 'type');
        array_unshift($definition, 'id');

        return $definition;
    }

}
