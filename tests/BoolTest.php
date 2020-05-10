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
    /**
     * The `not()` method on ESBool is an alias for the Shooped `toggle()` method.
     *
     * @return Eightfold\Shoop\ESBool
     */
    public function testNot()
    {
        $actual = Shoop::bool(true);
        $this->assertTrue($actual->unfold());

        $actual = $actual->not();
        $this->assertFalse($actual->unfold());
    }

    /**
     * The `or()` method on ESBool takes the original `bool` value, compares it to the given `bool` value, and returns an ESBool of whether one or the other values was true.
     *
     * @return Eightfold\Shoop\ESBool
     */
    public function testOr()
    {
        $actual = Shoop::bool(true);
        $this->assertTrue($actual->unfold());

        $actual = $actual->or(true);
        $this->assertTrue($actual->unfold());

        $actual = $actual->or(false);
        $this->assertTrue($actual->unfold());
    }

    /**
     * The `and()` method on ESBool takes the original `bool` value, compares it to the given `bool` value, and returns an ESBool of whether all the values are true.
     *
     * @return Eightfold\Shoop\ESBool
     */
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
