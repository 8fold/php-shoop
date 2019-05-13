<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\{
    ESString,
    ESArray
};

interface Wrappable
{
    static public function wrap(...$args);

    public function unwrap();
}
