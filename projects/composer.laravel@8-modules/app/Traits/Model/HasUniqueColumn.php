<?php

namespace App\Traits\Model;

trait HasUniqueColumn
{

    protected $uniqueColumn = 'slug';

    public function setUniqueColumn($value)
    {
        return $this->uniqueColumn = $value;
    }
    public function getUniqueColumn()
    {
        return $this->uniqueColumn;
    }
}
