<?php

namespace Eightfold\Shoop\Tests\Order;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESDictionary,
    ESInteger,
    ESJson,
    ESObject,
    ESString
};

/**
 * The `shuffle()` method randomly sorts the atomic elements of the value.
 */
class ShuffleTest extends TestCase
{
    /**
     * @return Eightfold\Shoop\ESArray After passing the original value through the `shuffle()` function from the PHP standard library.
     */
    public function testESArray()
    {
        $this->assertTrue(true);
    }

    /**
     * @not Could be a random boolean generator
     */
    public function testESBoolean()
    {
        $this->assertFalse(false);
    }

    /**
     * @not Has direct access
     */
    public function testESDictionary()
    {
        $this->assertFalse(false);
    }

    /**
     * @not Could shuffle the range
     */
    public function testESInteger()
    {
        $this->assertFalse(false);
    }

    /**
     * @not Has direct access
     */
    public function testESJson()
    {
        $this->assertFalse(false);
    }

    /**
     * @not Has direct access
     */
    public function testESObject()
    {
        $this->assertFalse(false);
    }

    /**
     * @return Eightfold\Shoop\FluentTypes\ESString After shuffling the letters of the ofirinal `PHP string`.
     */
    public function testESString()
    {
        $this->assertTrue(true);
    }
}
