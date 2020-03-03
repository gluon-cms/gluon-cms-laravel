<?php

namespace App\Gluon;


class GluonMap implements \JsonSerializable, \IteratorAggregate, \ArrayAccess
{
    protected $values = [];
    protected $defaultKey = null;
    protected $counter=0;

    public function __construct(){

    }

    public function set($key, $value){

        if ($key === null){
            $this->values[] = $value;
        } else {
            $this->values[$key] = $value;
        }

    }

    public function setDefaultKey($key){
        $this->defaultKey = $key;
    }

    public function getValues(){
        return $this->values;
    }





    public function getIterator () {
        return new \ArrayIterator($this->values);
    }


    public function offsetExists ( $offset ) {
        return isset($this->values[$offset]);
    }

    public function offsetGet ( $offset ){
        return $this->values[$offset];
    }

    public function offsetSet ( $offset , $value ) {

        $this->set($offset, $value);
    }

    public function offsetUnset ( $offset ) {
        unset($this->values[$offset]);
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
        $defaultString = $this->getDefaultValue() . "";

        if($defaultString) {
            return $defaultString;
        }

        return implode(", ", array_values($this->values));
    }
}
