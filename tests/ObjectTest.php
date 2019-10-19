<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\ESObject;

class ObjectTest extends TestCase
{
    public function testTypeJuggling()
    {
        $expected = [1, 2];
        $cast = (object) ["one" => 1, "two" => 2];
        $actual = Shoop::this($cast)->array();
        $this->assertEquals($expected, $actual->unfold());

        $actual = Shoop::this($cast)->bool();
        $this->assertTrue($actual->unfold());

        $actual = Shoop::this((new \stdClass()))->bool();
        $this->assertFalse($actual->unfold());

        $json = Shoop::this((new \stdClass()));
        $actual = $json->json();
        $this->assertEquals(json_encode($json), $actual->unfold());
    }

    public function testPhpInterfaces()
    {
        $base = ["one" => 1];
        $actual = (string) Shoop::this((object) $base);
        $this->assertEquals("Array([one] => 1)", $actual);
    }

    public function testMathLanguage()
    {
        $expected = (object) ["one" => 1, "two" => 2];
        $actual = Shoop::this((object) ["one" => 1])->plus("two", 2);
        $this->assertEquals($expected, $actual->unfold());

        $expected2 = (object) ["two" => 2];
        $actual = Shoop::this($expected)->minus("one");
        $this->assertEquals($expected2, $actual->unfold());

        $expected = [
            (object) ["one" => 1, "two" => 2],
            (object) ["one" => 1, "two" => 2]
        ];
        $actual = Shoop::this((object) ["one" => 1, "two" => 2])
            ->multiply(2);
        $this->assertEquals($expected, $actual->unfold());

        $expected = (object) ["members" => ["one", "two"], "values" => [1, 2]];
        $actual = Shoop::this((object) ["one" => 1, "two" => 2])
            ->divide();
        $this->assertEquals($expected, $actual->unfold());
    }
}
