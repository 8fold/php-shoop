<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\ESInt;

trait CountableImp
{
    public function count(): ESInt
    {
        return $this->int();
    }
}
