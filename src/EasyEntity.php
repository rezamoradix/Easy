<?php

namespace Rey\Easy;

use ReflectionClass;

/**
 * EasyEntity
 */
trait EasyEntity
{
    public function hasOne($className, $key = null)
    {
        $name = (new ReflectionClass($className))->getShortName();
        $key ??= $name . '_id';
        if (!isset($this->attributes[$name])) $this->attributes[$name] = $className::i()->where($key, $this->id)->first();
        return $this->attributes[$name];
    }

    public function belongsTo($className, $key = null)
    {
        $name = (new ReflectionClass($className))->getShortName();
        $key ??= $name . '_id';
        if (!isset($this->attributes[$name])) $this->attributes[$name] = $className::fetch($this->$key);
        return $this->attributes[$name];
    }

    public function hasMany($className, $key = null)
    {
        $name = (new ReflectionClass($className))->getShortName();
        $key ??= $name . '_id';
        if (!isset($this->attributes[$name])) $this->attributes[$name] = $className::i()->where($key, $this->id)->find();
        return $this->attributes[$name];
    }
}
