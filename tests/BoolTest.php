<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    Helpers\Type
};

class BoolTest extends TestCase
{
    public function testNot()
    {
        $actual = Shoop::bool(true);
        $this->assertTrue($actual->unfold());

        $actual = $actual->not();
        $this->assertFalse($actual->unfold());
    }

    public function testOr()
    {
        $actual = Shoop::bool(true);
        $this->assertTrue($actual->unfold());

        $actual = $actual->or(true);
        $this->assertTrue($actual->unfold());

        $actual = $actual->or(false);
        $this->assertTrue($actual->unfold());
    }

    public function testAnd()
    {
        $actual = Shoop::bool(true);
        $this->assertTrue($actual->unfold());

        $actual = $actual->and(true);
        $this->assertTrue($actual->unfold());

        $actual = $actual->and(false);
        $this->assertFalse($actual->unfold());
    }
}
