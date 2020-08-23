<?php

namespace Eightfold\Shoop\Tests\Typeable;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use Eightfold\Shoop\PipeFilters\TypeAsArray;
use Eightfold\Shoop\PipeFilters\Contracts\Arrayable;
use Eightfold\Shoop\PipeFilters\Contracts\ArrayableImp;

// use \stdClass;

// use Eightfold\Shoop\Shoop;

// use Eightfold\Shoop\FluentTypes\ESArray;
// use Eightfold\Shoop\FluentTypes\ESBoolean;
// use Eightfold\Shoop\FluentTypes\ESDictionary;
// use Eightfold\Shoop\FluentTypes\ESInteger;
// use Eightfold\Shoop\FluentTypes\ESJson;
// use Eightfold\Shoop\FluentTypes\ESTuple;
// use Eightfold\Shoop\FluentTypes\ESString;

/**
 * @group TypeAsArray
 */
class ArrayableTest extends TestCase
{
    /**
     * @test
     */
    public function boolean_zero_index_is_false_value()
    {
        AssertEquals::applyWith(
            [true, false],
            TypeAsArray::apply(),
            0.9
        )->unfoldUsing(false);

        AssertEquals::applyWith(
            [false, true],
            TypeAsArray::apply()
        )->unfoldUsing(true);
    }

    /**
     * @test
     */
    public function number_range_variations()
    {
        AssertEquals::applyWith(
            [0, 1, 2],
            TypeAsArray::apply(),
            1.47
        )->unfoldUsing(2);

        AssertEquals::applyWith(
            [1, 2],
            TypeAsArray::applyWith(1)
        )->unfoldUsing(2);

        AssertEquals::applyWith(
            [1, 2],
            TypeAsArray::applyWith(1)
        )->unfoldUsing(2.0);

        AssertEquals::applyWith(
            [1, 2],
            TypeAsArray::applyWith(1)
        )->unfoldUsing(2.5);

        AssertEquals::applyWith(
            [1, 2],
            TypeAsArray::applyWith(1)
        )->unfoldUsing(2.9);
    }

    /**
     * @test
     */
    public function string_variations()
    {
        AssertEquals::applyWith(
            ["8", "f", "o", "l", "d"],
            TypeAsArray::apply(),
            0.84
        )->unfoldUsing("8fold");

        AssertEquals::applyWith(
            ["8f", "ld"],
            TypeAsArray::applyWith("o")
        )->unfoldUsing("8fold");

        AssertEquals::applyWith(
            ["", "8", "8", ""],
            TypeAsArray::applyWith("!")
        )->unfoldUsing("!8!8!");

        AssertEquals::applyWith(
            ["8", "8"],
            TypeAsArray::applyWith("!", false)
        )->unfoldUsing("!8!8!");

        AssertEquals::applyWith(
            ["8", "*!8!"],
            TypeAsArray::applyWith("!", false, 2)
        )->unfoldUsing("8!*!8!");
    }

    /**
     * @test
     *
     * TODO: Write tests for other type juggling contracts - ?? - specifically regressions
     */
    public function tuple_variations()
    {
        AssertEquals::applyWith(
            ["8fold!"],
            TypeAsArray::apply(),
            1.09
        )->unfoldUsing('{"content":"8fold!"}');

        AssertEquals::applyWith(
            ["8fold!"],
            TypeAsArray::apply()
        )->unfoldUsing((object) ["content" => "8fold!"]);

        AssertEquals::applyWith(
            ["8fold!"],
            TypeAsArray::apply()
        )->unfoldUsing(
            new class {
                public $content = "8fold!";
            }
        );

        AssertEquals::applyWith(
            ["8fold!"],
            TypeAsArray::apply(),
            0.67
        )->unfoldUsing(
            new class implements Arrayable {
                use ArrayableImp;

                public function hasMember($member)
                {}

                public function at($member)
                {}

                public function plusMember($value, $member)
                {}

                public function minusMember($member)
                {}

                public function array(
                    $start = 0,
                    bool $includeEmpties = true,
                    int $limit = PHP_INT_MAX
                )
                {
                    return ["8fold!"];
                }

                public function efToArray(): array
                {
                    return $this->array();
                }
            }
        );

        AssertEquals::applyWith(
            ["8fold!"],
            TypeAsArray::apply(),
            0.67
        )->unfoldUsing(
            new class implements Arrayable {
                use ArrayableImp;

                public $content = "8fold!";

                public function hasMember($member)
                {}

                public function at($member)
                {}

                public function plusMember($value, $member)
                {}

                public function minusMember($member)
                {}

                public function array(
                    $start = 0,
                    bool $includeEmpties = true,
                    int $limit = PHP_INT_MAX
                )
                {
                    return explode($start, $this->content);
                }

                public function efToArray(): array
                {
                    return $this->array();
                }
            }
        );
    }

    // /**
    //  * @test
    //  */
    // public function ESArray()
    // {
    //     $using = ESArray::fold([false, true]);

    //     $expected = false;
    //     $actual   = $using[0];
    //     $this->assertEquals($expected, $actual);

    //     $expectedKeysSum      = 1;
    //     $expectedContentCount = 2;

    //     $sumKeys      = 0;
    //     $countContent = 0;
    //     foreach ($using as $key => $value) {
    //         $sumKeys      += $key;
    //         $countContent++;
    //     }
    //     $this->assertEquals($expectedKeysSum, $sumKeys);
    //     $this->assertEquals($expectedContentCount, $countContent);
    // }

    // /**
    //  * @test
    //  */
    // public function ESBoolean()
    // {
    //     $using = ESBoolean::fold(false);

    //     $expected = true;
    //     $actual   = $using["false"];
    //     $this->assertEquals($expected, $actual);

    //     $expected = false;
    //     $actual   = $using[0];
    //     $this->assertEquals($expected, $actual);

    //     $expectedKeys  = ["false", "true"];
    //     $expectedCount = 2;

    //     $keys  = [];
    //     $count = 0;
    //     foreach ($using as $key => $value) {
    //         $keys[] = $key;
    //         $count++;
    //     }
    //     $this->assertEquals($expectedKeys, $keys);
    //     $this->assertEquals($expectedCount, $count);
    // }

    // /**
    //  * @test
    //  */
    // public function ESDictionary()
    // {
    //     $using = ESDictionary::fold(["a" => "string", "b" => true, "c" => 1]);

    //     $expected = false;
    //     $actual   = $using[0];
    //     $this->assertEquals($expected, $actual);

    //     $expected = true;
    //     $actual   = $using["b"];
    //     $this->assertEquals($expected, $actual);

    //     $expectedKeys  = ["a", "b", "c"];
    //     $expectedCount = 3;

    //     $keys  = [];
    //     $count = 0;
    //     foreach ($using as $key => $value) {
    //         $keys[] = $key;
    //         $count++;
    //     }
    //     $this->assertEquals($expectedKeys, $keys);
    //     $this->assertEquals($expectedCount, $count);
    // }

    // /**
    //  * @test
    //  */
    // public function ESInteger()
    // {
    //     $using = ESInteger::fold(4);

    //     $expected = true;
    //     $actual   = $using[3];
    //     $this->assertEquals($expected, $actual);

    //     $expected = false;
    //     $actual   = $using["i2"];
    //     $this->assertEquals($expected, $actual);

    //     $expectedKeys  = [0, 1, 2, 3, 4];
    //     $expectedCount = 5;

    //     $keys  = [];
    //     $count = 0;
    //     foreach ($using as $key => $value) {
    //         $keys[] = $key;
    //         $count++;
    //     }
    //     $this->assertEquals($expectedKeys, $keys);
    //     $this->assertEquals($expectedCount, $count);
    // }

    // /**
    //  * @test
    //  * @group current
    //  */
    // public function ESString()
    // {
    //     $using = ESString::fold("8fold!");

    //     $expected = "!";
    //     $actual   = $using[5];
    //     $this->assertEquals($expected, $actual);

    //     $expected = false;
    //     $actual   = $using["i2"];
    //     $this->assertEquals($expected, $actual);

    //     $expectedKeys  = [0, 1, 2, 3, 4, 5];
    //     $expectedCount = 6;

    //     $keys  = [];
    //     $count = 0;
    //     foreach ($using as $key => $value) {
    //         $keys[] = $key;
    //         $count++;
    //     }
    //     $this->assertEquals($expectedKeys, $keys);
    //     $this->assertEquals($expectedCount, $count);
    // }
}
