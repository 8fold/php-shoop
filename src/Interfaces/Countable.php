<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESInt;

interface Countable extends \Countable
{
    // Does not make sense on ESBool
    public function count(): ESInt;

    // Does not make sense on ESBool
    public function plus(...$args); // 7.4 : self;

    // Does not make sense on ESBool
    public function minus(...$args); // 7.4 : self;

    // Does not make sense on ESBool
    public function divide($value = null);
}
