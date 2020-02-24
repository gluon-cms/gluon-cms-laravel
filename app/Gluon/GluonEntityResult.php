<?php

namespace App\Gluon;


class GluonEntityResult implements \JsonSerializable
{

    protected $meta = [];
    protected $values = [];
    protected $types = [];

    public function __construct($type, $id) {
        $this->meta['id'] = $id;
        $this->meta['type'] = $type;
    }

    public function set($type, $key, $value){
        $this->types[$key] = $type;
        $this->values[$key] = $value;
    }

    public function getValue($key){
        return isset($this->values[$key]) ? $this->values[$key] : null;
    }

    public function getMeta($key){
        return isset($this->meta[$key]) ? $this->meta[$key] : null;
    }

    public function getType($key){
        return isset($this->types[$key]) ? $this->types[$key] : null;
    }

    public function jsonSerialize() {
        return array_merge($this->meta, $this->values);
    }

}
