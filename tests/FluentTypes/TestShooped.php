<?php

namespace Eightfold\Shoop\Tests;


use Eightfold\Shoop\FluentTypes\Contracts\Shooped;
use Eightfold\Shoop\FluentTypes\Contracts\ShoopedImp;
use Eightfold\Shoop\FluentTypes\ESString;

class TestShooped implements Shooped
{
    use ShoopedImp;

    static public function processedMain($main): string
    {
        return Type::sanitizeType($main, ESString::class)->unfold();
    }
}
