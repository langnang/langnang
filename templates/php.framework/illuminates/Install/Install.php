<?php

namespace Illuminates\Install;

class Install extends \Illuminates\Core\Illuminate
{

  public $steps = [];
  public function addStep(InstallStep $step)
  {
    array_push($this->steps, $step);
  }
}
