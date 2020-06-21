<?php

namespace Eightfold\Shoop\Tests;

use Eightfold\Shoop\Helpers\Type;
use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Traits\ShoopedImp;
use Eightfold\Shoop\ESString;

class TestShooped implements Shooped
{
    use ShoopedImp;

    public function __construct($path)
    {
        $this->value = Type::sanitizeType($path, ESString::class)->unfold();
    }
}
