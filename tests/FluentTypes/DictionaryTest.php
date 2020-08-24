<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    Helpers\Type
};

class DictionaryTest extends TestCase
{
    public function testInterleve()
    {
        $expected = [1, "one", 2, "two", 3, "three"];
        $actual = Shoop::dictionary(["one" => 1, "two" => 2, "three" => 3])
            ->interleave();
        $this->assertSame($expected, $actual->unfold());
    }
}
