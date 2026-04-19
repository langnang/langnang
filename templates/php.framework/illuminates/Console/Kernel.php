<?php

namespace Illuminates\Console;

class Kernel extends \Illuminates\Core\Illuminate
{
  public function handle(ArgvInput $input, ConsoleOutput $output)
  {
    $output->print();
  }
}
