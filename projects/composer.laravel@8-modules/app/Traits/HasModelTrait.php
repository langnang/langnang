<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

trait HasModelTrait
{
    protected $__model = [
        'alias' => null,
        'class' => null,
        'validations' => [],
        'messages' => [],
    ];
    protected $__modelValue;

    public function setModel($values, $key = null)
    {
        if (empty($key)) {
            $this->__model = $values;
        } else {
            \Arr::set($this->__model, $key, $values);
        }
        return $this->__model;
    }
    public function getModel($key = null)
    {
        return \Arr::get($this->__model, $key);
    }
    public function mergeModel($values = [])
    {
        return $this->__model = array_merge($this->__model, $values);
    }
    public function validateModel($data, $key)
    {
        return Validator::make($data, Arr::get($this->__model, "validations.$key", []), Arr::get($this->__model, "messages", []));
    }
}
