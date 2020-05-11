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
    /**
     * The `each()` method on ESDictionary iterates over each element in the dictionary and passes it through the given closure.
     *
     * @return Eightfold\Shoop\ESDictionary
     */
    public function testEach()
    {
        $base = ["a" => "ay", "b" => "be", "c" => "see"];
        $expected = ["a-ay", "b-be", "c-see"];
        $actual = Shoop::dictionary($base)->each(function($value, $member) {
            return $member ."-". $value;
        });
        $this->assertEquals($expected, $actual->unfold());
    }
}
