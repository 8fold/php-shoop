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
     * @group current
     */
    public function ESArray()
    {
        $shoop = ESArray::fold([false, true]);

        $expected = false;
        $actual   = $shoop[0];
        $this->assertEquals($expected, $actual);

        $expectedKeysSum      = 1;
        $expectedContentCount = 2;

        $sumKeys      = 0;
        $countContent = 0;
        foreach ($shoop as $key => $value) {
            $sumKeys      += $key;
            $countContent += $value;
        }
        $this->assertEquals($expectedKeysSum, $sumKeys);
        $this->assertEquals($expectedContentCount, $countContent);
    }

    /**
     * @test
     */
    public function ESBoolean()
    {
        // AssertEqualsFluent::applyWith([false, true], 1.68)
        //     ->unfoldUsing(ESBoolean::fold(true)->array());
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        // AssertEqualsFluent::applyWith(["string", true], 1.37)
        //     ->unfoldUsing(
        //         ESDictionary::fold(["a" => "string", "b" => true])->array()
        //     );
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        // AssertEqualsFluent::applyWith([0, 1, 2, 3, 4, 5], 1.55)
        //     ->unfoldUsing(ESInteger::fold(5)->array());
    }

    /**
     * @test
     */
    public function ESJson()
    {
        // AssertEqualsFluent::applyWith(["test"], 2.22)
        //     ->unfoldUsing(ESJson::fold('{"test":"test"}')->array());
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        // AssertEqualsFluent::applyWith([], 8.49)
        //     ->unfoldUsing(ESTuple::fold(new stdClass)->array());
    }

    /**
     * @test
     */
    public function ESString()
    {
        // AssertEqualsFluent::applyWith(["h", "e", "l", "l", "o"], 2.32)
        //     ->unfoldUsing(ESString::fold("hello")->array());
    }
}
