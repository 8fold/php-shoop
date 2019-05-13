<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESString;

trait DescribableImp
{
    public function description(): ESString
    {
        return ESString::wrap("{$this->value}");
    }
}
