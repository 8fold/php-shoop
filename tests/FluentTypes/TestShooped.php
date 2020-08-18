<?php

namespace Eightfold\Shoop\Tests;


use Eightfold\Shoop\FluentTypes\Interfaces\Shooped;
use Eightfold\Shoop\FluentTypes\Traits\ShoopedImp;
use Eightfold\Shoop\FluentTypes\ESString;

class TestShooped implements Shooped
{
    use ShoopedImp;

    static public function processedMain($main): string
    {
        return Type::sanitizeType($main, ESString::class)->unfold();
    }
}
