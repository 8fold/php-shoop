<?php

namespace Eightfold\Shoop\Tests;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\ESInt;

class TestObject
{
    use ShoopedImp;

    public function __construct($args = null)
    {
        $this->value = $args;
    }

    public function int(): ESInt
    {
        if (is_int($this->value)) {
            return Shoop::int($this->value);
        }
        $count = count($this->arrayUnfolded());
        return Shoop::int($count);
    }
}
