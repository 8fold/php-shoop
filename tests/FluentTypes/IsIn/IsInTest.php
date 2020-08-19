<?php

namespace Eightfold\Shoop\Tests\IsIn;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

class IsInTest extends TestCase
{
    public function testESArray()
    {
        $inner = [true, false, false];
        $base = [$inner, true, false, false];
        $actual = Shoop::array($inner)->isIn($base);
        $this->assertTrue($actual->unfold());

        $actual = Shoop::array($inner)->isIn($base, function($result) {
            return ! $result->unfold();
        });
        $this->assertFalse($actual);
    }

    public function testESBoolean()
    {
        $inner = [false, false, false];
        $actual = Shoop::bool(false)->isIn($inner);
        $this->assertTrue($actual->unfold());

        $actual = Shoop::bool(true)->isIn($inner, function($result) {
            return $result->unfold();
        });
        $this->assertFalse($actual);
    }

    public function testESDictionary()
    {
        $inner = ["one" => 1, "two" => 2, "three" => 3];
        $base = ["a" => $inner, "b" => 2, "c" => 3];
        $actual = Shoop::dictionary($inner)->isIn($base);
        $this->assertTrue($actual->unfold());

        $actual = Shoop::dictionary(["d" => 4])->isIn($base, function($result) {
            return ! $result->unfold();
        });
        $this->assertTrue($actual);
    }

    public function testESInt()
    {
        $base = [1, 2, 3, 4];
        $actual = Shoop::int(2)->isIn($base);
        $this->assertTrue($actual->unfold());

        $actual = Shoop::int(5)->isNotIn($base);
        $this->assertTrue($actual->unfold());

        $actual = Shoop::int(2)->isIn($base, function($result) {
            return ($result->unfold()) ? true : false;
        });
        $this->assertTrue($actual);
    }

    public function testESJson()
    {
        $inner = '{"hello":"world"}';
        $base = "blah ". $inner ."blah";
        $actual = Shoop::json($inner)->isIn($base);
        $this->assertTrue($actual->unfold());

        $actual = Shoop::json($inner)->isNotIn("blah", function($result) {
            return $result;
        });
        $this->assertTrue($actual->unfold());
    }

    public function testESObject()
    {
        $inner = new \stdClass();
        $inner->test = "test";
        $base = new \stdClass();
        $base->inner = $inner;
        $actual = Shoop::object($inner)->isIn($base);
        $this->assertTrue($actual->unfold());
    }

    public function testESString()
    {
        $inner = "World";
        $base = "Hello, World!";
        $actual = Shoop::string($inner)->isIn($base, function($result) {
            return ! $result->unfold();
        });
        $this->assertFalse($actual);
    }
}
