<?php

namespace App\Gluon;


class GluonCollapsableValue implements \JsonSerializable
{

    public $default = "";

    public function __construct($value){
        $this->default = $value ? $value : "";
    }

    public function jsonSerialize() {
        return $this;
    }

    public function __toString(){
        return $this->default;
    }
}
