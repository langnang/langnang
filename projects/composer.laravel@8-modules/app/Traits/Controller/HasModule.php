<?php

namespace App\Traits\Controller;

trait HasModule
{
    /**
     * @var string $module
     */
    protected $module;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'CheatSheet';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'cheatsheet';


    public function setModule($module)
    {
        $this->module = $module;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function getModuleConfig()
    {
        return \Module::getCurrentConfig();
    }
}
