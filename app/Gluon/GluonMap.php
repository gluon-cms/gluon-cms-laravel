<?php

namespace App\Gluon;


class GluonMap implements \JsonSerializable
{
    protected $values = [];
    protected $defaultKey = null;

    public function __construct(){

    }

    public function set($key, $value){
        $this->values[$key] = $value;
    }

    public function setDefaultKey($key){
        $this->defaultKey = $key;
    }

    public function getValues(){
        return $this->values;
    }

    public function merge(GluonCollapsableValue $collapsableValue){
        $this->values = array_merge($this->values, $collapsableValue->getValues());
    }

    public function jsonSerialize() {
        if (! $this->defaultKey) {
            return $this->values;
        }

        if (count($this->values) > 1) {
            return $this->values;
        }

        if (! isset($this->values[$this->defaultKey])) {
            return $this->values;
        }

        return $this->values[$this->defaultKey];
    }

    public function getDefaultValue(){
        if (! $this->defaultKey || !isset($this->values[$this->defaultKey])) {
            return null;
        }

        return $this->values[$this->defaultKey];
    }

    public function __get($key){
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }

        $keys = implode(", ", array_keys($this->values));
        throw new \Exception("Cannot find key [$key] in this map. Available keys are [$keys]");
        
    }

    public function __toString(){
        $default = $this->getDefaultValue();
        return "$default";
    }
}
