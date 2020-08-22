<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use Eightfold\Shoop\PipeFilters\TypeIs;
use Eightfold\Shoop\PipeFilters\TypeOf;

use \stdClass;

use Eightfold\Shoop\PipeFilters\TypeAsBoolean;
use Eightfold\Shoop\PipeFilters\TypeAsInteger;
use Eightfold\Shoop\PipeFilters\TypeAsNumber;
use Eightfold\Shoop\PipeFilters\TypeAsString;
use Eightfold\Shoop\PipeFilters\TypeAsArray;
use Eightfold\Shoop\PipeFilters\TypeAsDictionary;
use Eightfold\Shoop\PipeFilters\TypeAsTuple;
use Eightfold\Shoop\PipeFilters\TypeAsJson;

/**
 * @group TypeChecking
 *
 * @group TypeAs
 */
class TypeAsTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            true,
            TypeAsBoolean::apply(),
            1.102
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            false,
            TypeAsBoolean::apply()
        )->unfoldUsing(0);

        AssertEquals::applyWith(
            true,
            TypeAsBoolean::apply()
        )->unfoldUsing(100.0);

        AssertEquals::applyWith(
            false,
            TypeAsBoolean::apply()
        )->unfoldUsing([]);

        AssertEquals::applyWith(
            false,
            TypeAsBoolean::apply()
        )->unfoldUsing(new stdClass);

        AssertEquals::applyWith(
            false,
            TypeAsBoolean::apply()
        )->unfoldUsing(new class {});

        AssertEquals::applyWith(
            true,
            TypeAsBoolean::apply()
        )->unfoldUsing(new class {
            public $public = "content";
        });

        AssertEquals::applyWith(
            true,
            TypeAsBoolean::apply()
        )->unfoldUsing(["a" => true]);
    }

    /**
     * @test
     */
    public function number()
    {
        AssertEquals::applyWith(
            1,
            TypeAsInteger::apply(),
            0.31
        )->unfoldUsing(1);

        AssertEquals::applyWith(
            2,
            TypeAsInteger::apply()
        )->unfoldUsing(2.1);

        AssertEquals::applyWith(
            3,
            TypeAsInteger::apply()
        )->unfoldUsing([3, 4, 5]);

        AssertEquals::applyWith(
            3,
            TypeAsInteger::apply()
        )->unfoldUsing(["a" => 3, "b" => 4, "c" => 5]);

        AssertEquals::applyWith(
            3,
            TypeAsInteger::apply()
        )->unfoldUsing((object) ["a" => 3, "b" => 4, "c" => 5]);

        AssertEquals::applyWith(
            3.2,
            TypeAsNumber::apply()
        )->unfoldUsing(3.2);
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            "true",
            TypeAsString::apply()
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            "1",
            TypeAsString::apply()
        )->unfoldUsing(1);

        AssertEquals::applyWith(
            "1.25",
            TypeAsString::apply()
        )->unfoldUsing(1.25);

        AssertEquals::applyWith(
            "8fold!",
            TypeAsString::apply()
        )->unfoldUsing(["8", "f", "o", "l", "d", "!"]);

        AssertEquals::applyWith(
            "8!f!o!l!d!!",
            TypeAsString::applyWith("!")
        )->unfoldUsing(["8", "f", "o", "l", "d", "!"]);
    }

    /**
     * @test
     *
     * @group current_one
     */
    public function array()
    {
        AssertEquals::applyWith(
            [true, false],
            TypeAsArray::apply()
        )->unfoldUsing(false);

        AssertEquals::applyWith(
            [false, true],
            TypeAsArray::apply()
        )->unfoldUsing(true);

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

        AssertEquals::applyWith(
            ["8fold!"],
            TypeAsArray::apply(),
            3.71
        )->unfoldUsing('{"content":"8fold!"}');
    }

    /**
     * @test
     */
    public function dictionary()
    {
        AssertEquals::applyWith(
            ["false" => false, "true" => true],
            TypeAsDictionary::apply()
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            ["false" => true, "true" => false],
            TypeAsDictionary::apply()
        )->unfoldUsing(false);

        AssertEquals::applyWith(
            ["i0" => 0, "i1" => 1],
            TypeAsDictionary::apply()
        )->unfoldUsing(1);

        AssertEquals::applyWith(
            ["efs0" => 2, "efs1" => 3, "efs2" => 4],
            TypeAsDictionary::applyWith(2, "efs")
        )->unfoldUsing(4);

        AssertEquals::applyWith(
            ["efs0" => 2, "efs1" => 3, "efs2" => 4],
            TypeAsDictionary::applyWith("efs")
        )->unfoldUsing([2, 3, 4]);

        AssertEquals::applyWith(
            ["efs0" => 2, "efs1" => 3, "efs2" => 4],
            TypeAsDictionary::applyWith("efs")
        )->unfoldUsing([2, 3, 4]);

        AssertEquals::applyWith(
            ["content" => "8fold!"],
            TypeAsDictionary::apply()
        )->unfoldUsing("8fold!");

        AssertEquals::applyWith(
            ["content" => "8fold!"],
            TypeAsDictionary::apply()
        )->unfoldUsing('{"content":"8fold!"}');
    }

    /**
     * @test
     */
    public function tuple()
    {
        AssertEquals::applyWith(
            (object) ["true" => true, "false" => false],
            TypeAsTuple::apply(),
            1.3
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            (object) ["i0" => 0, "i1" => 1, "i2" => 2],
            TypeAsTuple::apply(),
            1.5
        )->unfoldUsing(2);

        AssertEquals::applyWith(
            (object) ["i0" => 0, "i1" => 1, "i2" => 2],
            TypeAsTuple::apply(),
            0.4
        )->unfoldUsing(2.5);

        AssertEquals::applyWith(
            (object) ["content" => "8"],
            TypeAsTuple::apply()
        )->unfoldUsing("8");

        AssertEquals::applyWith(
            (object) ["i0" => 2, "i1" => 3],
            TypeAsTuple::apply()
        )->unfoldUsing([2, 3]);

        AssertEquals::applyWith(
            (object) ["first" => 2, "second" => 3],
            TypeAsTuple::apply()
        )->unfoldUsing(["first" => 2, "second" => 3]);

        AssertEquals::applyWith(
            (object) ["first" => 2, "second" => 3],
            TypeAsTuple::apply()
        )->unfoldUsing(
            new class {
                public $first = 2;
                public $second = 3;
                private $third = 4;
                public function efToBool()
                {
                    return false;
                }
            }
        );
    }

    /**
     * @test
     */
    public function json()
    {
        AssertEquals::applyWith(
            '{"false":true,"true":false}',
            TypeAsJson::apply(),
            1.96
        )->unfoldUsing(false);

        AssertEquals::applyWith(
            '{"i0":0,"i1":1,"i2":2}',
            TypeAsJson::apply(),
            1.25
        )->unfoldUsing(2);

        AssertEquals::applyWith(
            '{"i0":0,"i1":1,"i2":2}',
            TypeAsJson::apply()
        )->unfoldUsing(2.2);

        AssertEquals::applyWith(
            '{"content":"8fold"}',
            TypeAsJson::apply()
        )->unfoldUsing("8fold");

        AssertEquals::applyWith(
            '{"i0":0,"i1":1,"i2":2}',
            TypeAsJson::apply()
        )->unfoldUsing([0, 1, 2]);


        AssertEquals::applyWith(
            '{"first":0,"second":1}',
            TypeAsJson::apply()
        )->unfoldUsing(["first" => 0, "second" => 1]);

        AssertEquals::applyWith(
            '{"first":0,"second":1}',
            TypeAsJson::apply()
        )->unfoldUsing((object) ["first" => 0, "second" => 1]);
    }

    /**
     * @test
     *
     * Objects only transform *into* other types.
     */
    public function objects()
    {
        $using = new class {
            public $public = "content";
            private $private = "private";
            public function someAction()
            {
                return false;
            }
        };

        AssertEquals::applyWith(
            (object) ["public" => "content"],
            TypeAsTuple::apply(),
            0.76
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            ["public" => "content"],
            TypeAsDictionary::apply()
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            ["content"],
            TypeAsArray::apply()
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            1.0,
            TypeAsNumber::apply()
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            1,
            TypeAsInteger::apply()
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            true,
            TypeAsBoolean::apply()
        )->unfoldUsing($using);
    }
}
