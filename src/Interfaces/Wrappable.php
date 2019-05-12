<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\{
    ESString,
    ESArray
};

interface Wrappable
{
    static public function wrap(array $array);

    static public function wrapString(string $string);

    public function unwrap();
}
