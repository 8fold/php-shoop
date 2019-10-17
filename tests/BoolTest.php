<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESBool;
use Eightfold\Shoop\Shoop;

class BoolTest extends TestCase
{
    public function testTypeJuggling()
    {
        $actual = Shoop::this(true)->array();
        $this->assertTrue(true, $actual->first());

        $actual = Shoop::this(false)->dictionary();
        $this->assertFalse($actual->get("true")->unfold());

        $actual = Shoop::this(true)->dictionary();
        $this->assertTrue($actual->get("true")->unfold());

        $actual = Shoop::this(true)->object();
        $this->assertTrue($actual->unfold()->true);

        $actual = Shoop::this(true)->int();
        $this->assertEquals(1, $actual->unfold());
    }

    public function testPhpSingleMethodInterfaces()
    {
        $actual = Shoop::this(true);
        $this->assertEquals("true", (string) $actual);
    }

    public function testManipulations()
    {
        $actual = Shoop::this(true)->toggle();
        $this->assertFalse($actual->unfold());

        $this->assertFalse($actual->sort()->unfold());

        $this->assertTrue(Shoop::this(true)->start()->unfold());
        $this->assertFalse(Shoop::this(true)->end()->unfold());
    }

    public function testSearch()
    {
        $actual = Shoop::this(true)->startsWith("t");
        $this->assertTrue($actual->unfold());

        $actual = Shoop::this(false)->endsWith("se");
        $this->assertFalse($actual->unfold());
    }

    public function testMathLanguage()
    {
        $actual = Shoop::this(true);
        $this->assertTrue($actual->plus()->unfold());

        $actual = Shoop::this(true);
        $this->assertFalse($actual->minus()->unfold());

        $expected = [true, true, true];
        $actual = Shoop::this(true)->multiply(3);
        $this->assertEquals($expected, $actual->unfold());

        $expected = true;
        $actual = Shoop::this(true)->divide(3);
        $this->assertEquals($expected, $actual->unfold());

        $expected = [true, false];
        $actual = Shoop::this(true)->split();
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
