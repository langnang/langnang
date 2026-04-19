<?php

namespace App\Traits;

trait HasOptionsTrait
{
    public $__options = [];
    public function setOptions($values, $key = null)
    {
        if (!empty($key)) {
            \Arr::set($this->__options, $key, $values);
        } else {
            $this->__options = array_merge($this->__options, $values);
        }
        return $this->__options;
    }
    public function getOptions($key = null, $default = null)
    {
        if (empty($key))
            return $this->__options;
        return \Arr::get($this->__options, $key, $default);
    }
    public function mergeOptions($values)
    {
        $this->__options = array_merge($this->__options, $values);
    }

    private function _initOptions(...$values)
    {
        $values = cache_remember(function () use ($values) {
            if (empty($values)) {
                $builder = \App\Models\Option::where('name', 'like', 'global.%');
                foreach (['option', 'user', 'meta', 'content', 'link', 'file', 'comment', 'field'] as  $key) {
                    $builder = $builder->orWhere('name', 'like', $key . '.%');
                }
                if (\Arr::get($this->__module, 'name'))
                    $builder = $builder->orWhere('name', 'like', \Arr::get($this->__module, 'alias', 'home') . '.%');
                $values = $builder->get()->toArray();
            }
            return $values;
        });
        foreach ($values as $value) {
            if (isset($value['name']))
                $this->setOptions($value['value'], $value['name'],);
        }
    }
}
