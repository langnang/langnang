<?php

namespace App\Traits;

/**
 * Summary of HasReturn
 */
trait HasReturnTrait
{
    protected $__return = [];
    public function setReturn($values, $key = null)
    {
        if (empty($key)) {
            $this->__return = $values;
        } else {
            \Arr::set($this->__return, $key, $values);
        }
        return $this->__return;
    }
    public function getReturn($key = null)
    {
        return \Arr::get($this->__return, $key);
    }
    public function mergeReturn($values = [])
    {
        return $this->__return = array_merge($this->__return, $values);
    }
}
