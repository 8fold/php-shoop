<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\{
    PhpTypeJuggle,
    PhpAssociativeArray,
    PhpObject
};

class PhpInt
{
    static public function isOdd(int $int): bool
    {
        return $int&1;
    }

    static public function isEven(int $int): bool
    {
        return $int % 2 === 0;
    }
}
