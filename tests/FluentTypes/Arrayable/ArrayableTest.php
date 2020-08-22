<?php

namespace Eightfold\Shoop\Tests\Typeable;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use \stdClass;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESDictionary;
use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\FluentTypes\ESJson;
use Eightfold\Shoop\FluentTypes\ESTuple;
use Eightfold\Shoop\FluentTypes\ESString;

/**
 * @group Arrayable
 */
class ArrayableTest extends TestCase
{
    /**
     * @test
     */
    public function ESArray()
    {
        $using = ESArray::fold([false, true]);

        $expected = false;
        $actual   = $using[0];
        $this->assertEquals($expected, $actual);

        $expectedKeysSum      = 1;
        $expectedContentCount = 2;

        $sumKeys      = 0;
        $countContent = 0;
        foreach ($using as $key => $value) {
            $sumKeys      += $key;
            $countContent++;
        }
        $this->assertEquals($expectedKeysSum, $sumKeys);
        $this->assertEquals($expectedContentCount, $countContent);
    }

    /**
     * @test
     */
    public function ESBoolean()
    {
        $using = ESBoolean::fold(false);

        $expected = true;
        $actual   = $using["false"];
        $this->assertEquals($expected, $actual);

        $expected = false;
        $actual   = $using[0];
        $this->assertEquals($expected, $actual);

        $expectedKeys  = ["false", "true"];
        $expectedCount = 2;

        $keys  = [];
        $count = 0;
        foreach ($using as $key => $value) {
            $keys[] = $key;
            $count++;
        }
        $this->assertEquals($expectedKeys, $keys);
        $this->assertEquals($expectedCount, $count);
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        $using = ESDictionary::fold(["a" => "string", "b" => true, "c" => 1]);

        $expected = false;
        $actual   = $using[0];
        $this->assertEquals($expected, $actual);

        $expected = true;
        $actual   = $using["b"];
        $this->assertEquals($expected, $actual);

        $expectedKeys  = ["a", "b", "c"];
        $expectedCount = 3;

        $keys  = [];
        $count = 0;
        foreach ($using as $key => $value) {
            $keys[] = $key;
            $count++;
        }
        $this->assertEquals($expectedKeys, $keys);
        $this->assertEquals($expectedCount, $count);
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        $using = ESInteger::fold(4);

        $expected = true;
        $actual   = $using[3];
        $this->assertEquals($expected, $actual);

        $expected = false;
        $actual   = $using["i2"];
        $this->assertEquals($expected, $actual);

        $expectedKeys  = [0, 1, 2, 3, 4];
        $expectedCount = 5;

        $keys  = [];
        $count = 0;
        foreach ($using as $key => $value) {
            $keys[] = $key;
            $count++;
        }
        $this->assertEquals($expectedKeys, $keys);
        $this->assertEquals($expectedCount, $count);
    }

    /**
     * @test
     * @group current
     */
    public function ESString()
    {
        $using = ESString::fold("8fold!");

        $expected = "!";
        $actual   = $using[5];
        $this->assertEquals($expected, $actual);

        $expected = false;
        $actual   = $using["i2"];
        $this->assertEquals($expected, $actual);

        $expectedKeys  = [0, 1, 2, 3, 4, 5];
        $expectedCount = 6;

        $keys  = [];
        $count = 0;
        foreach ($using as $key => $value) {
            $keys[] = $key;
            $count++;
        }
        $this->assertEquals($expectedKeys, $keys);
        $this->assertEquals($expectedCount, $count);
    }
}
