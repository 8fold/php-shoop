<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

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
     */
    public function array()
    {
        AssertEquals::applyWith(
            [false],
            TypeAsArray::apply()
        )->unfoldUsing(false);

        AssertEquals::applyWith(
            [0, 1, 2],
            TypeAsArray::apply()
        )->unfoldUsing(2);

        AssertEquals::applyWith(
            [1, 2],
            TypeAsArray::applyWith(1)
        )->unfoldUsing(2);

        AssertEquals::applyWith(
            ["8", "f", "o", "l", "d"],
            TypeAsArray::apply()
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
     */
    public function dictionary()
    {
        AssertEquals::applyWith(
            ["true" => true, "false" => false],
            TypeAsDictionary::apply()
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            ["true" => false, "false" => true],
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
            ["efs0" => "8", "efs1" => "f"],
            TypeAsDictionary::applyWith("!", false, 2, "efs")
        )->unfoldUsing("8!f");
    }

    /**
     * @test
     */
    public function tuple()
    {
        AssertEquals::applyWith(
            (object) ["public" => "content", "publicEmptyString" => ""],
            TypeAs::applyWith("tuple")
        )->unfoldUsing((object) ["public" => "content", "publicEmptyString" => ""]);

        AssertEquals::applyWith(
            ["public" => "content", "publicEmptyString" => ""],
            TypeAs::applyWith("dictionary")
        )->unfoldUsing((object) ["public" => "content", "publicEmptyString" => ""]);

        AssertEquals::applyWith(
            ["content", ""],
            TypeAs::applyWith("array")
        )->unfoldUsing((object) ["public" => "content", "publicEmptyString" => ""]);

        AssertEquals::applyWith(
            2,
            TypeAs::applyWith("integer")
        )->unfoldUsing((object) ["public" => "content", "publicEmptyString" => ""]);

        AssertEquals::applyWith(
            2.0,
            TypeAs::applyWith("float")
        )->unfoldUsing((object) ["public" => "content", "publicEmptyString" => ""]);

        AssertEquals::applyWith(
            true,
            TypeAs::applyWith("boolean")
        )->unfoldUsing((object) ["public" => "content", "publicEmptyString" => ""]);

        AssertEquals::applyWith(
            '{"public":"content","publicEmptyString":""}',
            TypeAs::applyWith("json")
        )->unfoldUsing((object) ["public" => "content", "publicEmptyString" => ""]);
    }

    /**
     * @test
     */
    public function json()
    {
        AssertEquals::applyWith(
            (object) ["public" => "content", "boolean" => true],
            TypeAs::applyWith("tuple")
        )->unfoldUsing('{"public":"content","boolean":true}');

        AssertEquals::applyWith(
            ["public" => "content", "boolean" => true],
            TypeAs::applyWith("dictionary")
        )->unfoldUsing('{"public":"content","boolean":true}');

        AssertEquals::applyWith(
            ["content", true],
            TypeAs::applyWith("array")
        )->unfoldUsing('{"public":"content","boolean":true}');

        AssertEquals::applyWith(
            2,
            TypeAs::applyWith("integer")
        )->unfoldUsing('{"public":"content","boolean":true}');

        AssertEquals::applyWith(
            2.0,
            TypeAs::applyWith("float")
        )->unfoldUsing('{"public":"content","boolean":true}');

        AssertEquals::applyWith(
            true,
            TypeAs::applyWith("boolean")
        )->unfoldUsing('{"public":"content","boolean":true}');
    }

    /**
     * @test
     *
     * Only does downcasting, really.
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
            TypeAs::applyWith("tuple")
        )->unfoldUsing($using);


        AssertEquals::applyWith(
            (object) ["public" => "content"],
            TypeAs::applyWith("tuple")
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            ["public" => "content"],
            TypeAs::applyWith("dictionary")
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            ["content"],
            TypeAs::applyWith("array")
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            1.0,
            TypeAs::applyWith("float")
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            1,
            TypeAs::applyWith("integer")
        )->unfoldUsing($using);

        AssertEquals::applyWith(
            true,
            TypeAs::applyWith("integer")
        )->unfoldUsing($using);
    }
}
