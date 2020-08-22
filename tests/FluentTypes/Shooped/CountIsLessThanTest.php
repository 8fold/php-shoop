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
 * @group CountIsLessThan
 *
 * The `countIsLessThan()` method converts the Shoop type using the `count()` method (using the PHP Countable interface) and uses the result to compare the given value to. The result ESBoolean and closure, if available, is then passed to the `isLessThan()` method.
 *
 * Note: Expects both values to be of the same type, Shoop type, or combination (cannot compare an `int` to a `bool`, for example).
 *
 * @return Eightfold\Shoop\ESBoolean
 */
class CountIsLessThanTest extends TestCase
{
    public function ESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->countIsLessThan(3);
        $this->assertTrue($actual->unfold());
    }

    public function ESBoolean()
    {
        $base = true;
        $actual = ESBoolean::fold($base)->countIsLessThan(false);
        $this->assertFalse($actual->unfold());
    }

    public function ESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->countIsLessThan(1);
        $this->assertFalse($actual->unfold());
    }

    public function ESInteger()
    {
        $base = 11;
        $actual = ESInteger::fold(11)->countIsLessThan(9);
        $this->assertFalse($actual->unfold());
    }

    public function ESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->countIsLessThan(1);
        $this->assertFalse($actual->unfold());
    }

    public function ESTuple()
    {
        $base = new \stdClass();
        $base->test = "test";

        $actual = ESTuple::fold($base)->countIsLessThan(1);
        $this->assertFalse($actual->unfold());
    }

    public function ESString()
    {
        $actual = ESString::fold("a")->countIsLessThan(3);
        $this->assertTrue($actual->unfold());

        $actual = ESString::fold("b")->countIsLessThan(1);
        $this->assertFalse($actual->unfold());
    }
}
