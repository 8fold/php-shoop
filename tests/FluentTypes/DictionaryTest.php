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

    public function testInterleve()
    {
        $expected = [1, "one", 2, "two", 3, "three"];
        $actual = Shoop::dictionary(["one" => 1, "two" => 2, "three" => 3])
            ->interleave();
        $this->assertSame($expected, $actual->unfold());
    }
}
