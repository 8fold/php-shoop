<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\ESInt;

trait MathOperationsImp
{
    public function count(): ESInt
    {
        return $this->int();
    }

    public function multiply($int = 1)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $array = [];
        for ($i = 0; $i < $int; $i++) {
            $array[] = $this;
        }
        return Shoop::array($array);
    }

}
