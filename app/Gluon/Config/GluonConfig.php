<?php

namespace App\Gluon\Config;
use Config;

class GluonConfig
{

    public function getTypeList(){
        $types = array_keys(Config::get("gluon.entities"));
        return $types;
    }

    public function getDescription($type){
        $description = Config::get("gluon.entities.$type");
        return $this->completeDescription($description);
    }

    public function completeDescription($description){
        array_unshift($description, 'type');
        array_unshift($description, 'id');

        return $description;
    }

}
