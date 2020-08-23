<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESJson;
use Eightfold\Shoop\FluentTypes\ESTuple;
use Eightfold\Shoop\FluentTypes\ESString;

/**
 * @group  CountIsGreaterThanOrEqualTo
 *
 * The `countIsGreaterThanOrEqualTo()` method converts the Shoop type using the `count()` method (using the PHP Countable interface) and uses the result to compare the given value to. The result ESBoolean and closure, if available, is then passed to the `isGreaterThanOrEqualTo()` method.
 *
 * Note: Expects both values to be of the same type, Shoop type, or combination (cannot compare an `int` to a `bool`, for example).
 *
 * @return Eightfold\Shoop\ESBoolean
 */
class CountIsGreaterThanOrEqualToTest extends TestCase
{
    public function ESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->countIsGreaterThanOrEqualTo(2);
        $this->assertTrue($actual->unfold());
    }

    public function ESBoolean()
    {
        $base = true;
        $actual = ESBoolean::fold($base)->countIsGreaterThanOrEqualTo(0);
        $this->assertTrue($actual->unfold());
    }

    public function ESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->countIsGreaterThanOrEqualTo(1);
        $this->assertTrue($actual->unfold());
    }

    public function ESInteger()
    {
        $base = 11;
        $actual = ESInteger::fold(11)->countIsGreaterThanOrEqualTo($base);
        $this->assertTrue($actual->unfold());
    }

    public function ESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->countIsGreaterThanOrEqualTo(1);
        $this->assertTrue($actual->unfold());
    }

    /**
     * @test
     */
    public function ESTuple_has_count()
    {
        $base = new \stdClass();
        $base->test = "test";

        $actual = ESTuple::fold($base)->countIsGreaterThanOrEqualTo(1);
        $this->assertTrue($actual->unfold());
    }

    /**
     * @test
     */
    public function ESString_has_count()
    {
        $actual = ESString::fold("a")->countIsGreaterThanOrEqualTo(2);
        $this->assertFalse($actual->unfold());

        $actual = ESString::fold("b")->countIsGreaterThanOrEqualTo(1);
        $this->assertTrue($actual->unfold());
    }
}
