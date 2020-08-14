<?php

namespace Eightfold\Shoop\Tests;

use Eightfold\Shoop\Helpers\Type;
use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Traits\ShoopedImp;
use Eightfold\Shoop\ESString;

class TestShooped implements Shooped
{
    use ShoopedImp;

    static public function processedMain($main): string
    {
        return Type::sanitizeType($main, ESString::class)->unfold();
    }
}
