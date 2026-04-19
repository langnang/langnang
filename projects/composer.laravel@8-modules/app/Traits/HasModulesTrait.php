<?php

namespace App\Traits;

trait HasModulesTrait
{
    public $__modules = [];
    private function _initModules()
    {
        $this->__modules = \App\Models\Meta::getRootModules();
        // $this->__modules =  \Module::allEnabled();
    }
    public function setModules($values = null, $key = null)
    {
        $this->__modules =  \Module::allEnabled();
    }

    public function getModules()
    {
        return $this->__modules;
        return array_map(function ($module) {
            return [
                'name' => $module->getName(),
                'nameCn' => \config($module->getLowerName() . '.nameCn'),
                'lowerName' => $module->getLowerName(),
                'slug' => \config($module->getLowerName() . '.slug', $module->getLowerName()),
                'status' => \config($module->getLowerName() . '.status', 'public'),
            ];
        },  $this->__modules);
    }
}
