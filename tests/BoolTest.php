<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESBool;
use Eightfold\Shoop\Shoop;

class BoolTest extends TestCase
{
    public function testTypeJuggling()
    {
        $actual = Shoop::bool(true)->array();
        $this->assertTrue(true, $actual->first());

        $actual = Shoop::bool(false)->dictionary();
        $this->assertFalse($actual->unfold()["true"]);

        $actual = Shoop::bool(true)->dictionary();
        $this->assertTrue($actual->unfold()["true"]);

        // $actual = Shoop::bool(true)->object();
        // $this->assertTrue($actual->unfold()->true);

        $actual = Shoop::bool(true)->int();
        $this->assertEquals(1, $actual->unfold());
    }

    public function testPhpSingleMethodInterfaces()
    {
        $actual = Shoop::bool(true);
        $this->assertEquals("true", (string) $actual);
    }

    public function testManipulations()
    {
        $actual = Shoop::this(true)->toggle();
        $this->assertFalse($actual->unfold());
    }

    public function testMathLanguage()
    {
        $expected = [true, true, true];
        $actual = Shoop::this(true)->multiply(3);
        $this->assertEquals($expected, $actual->unfold());
    }

    public function testComparison()
    {
        $true = Shoop::this(true);
        $false = Shoop::this(false);

        $this->assertFalse($true->is($false)->unfold());

        $this->assertTrue($true->isGreaterThan($false)->unfold());

        $this->assertFalse($true->isLessThan($false)->unfold());
    }

    public function testOther()
    {
        $this->assertFalse(Shoop::this(true)->not()->unfold());

        $this->assertTrue(Shoop::this(true)->or(false)->unfold());
        $this->assertFalse(Shoop::this(false)->or(false)->unfold());

        $this->assertTrue(Shoop::this(true)->and(true)->unfold());
        $this->assertFalse(Shoop::this(true)->and(false)->unfold());
    }
}
