<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    Helpers\Type
};

class DictionaryTest extends TestCase
{
    public function testEach()
    {
        $base = ["a" => "ay", "b" => "be", "c" => "see"];
        $expected = ["a-ay", "b-be", "c-see"];
        $actual = Shoop::dictionary($base)->each(function($value, $key) {
            return $key ."-". $value;
        });
        $this->assertEquals($expected, $actual->unfold());
    }
}
