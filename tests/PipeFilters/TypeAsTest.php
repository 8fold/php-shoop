<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use \stdClass;

use Eightfold\Shoop\PipeFilters\TypeAs;

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
            TypeAs::applyWith("boolean"),
            0.95
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            0,
            TypeAs::applyWith("integer")
        )->unfoldUsing(false);

        AssertEquals::applyWith(
            1.0,
            TypeAs::applyWith("float")
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            [true],
            TypeAs::applyWith("array")
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            ["true" => false, "false" => true],
            TypeAs::applyWith("dictionary")
        )->unfoldUsing(false);

        AssertEquals::applyWith(
            (object) ["true" => true, "false" => false],
            TypeAs::applyWith("tuple")
        )->unfoldUsing(true);

        AssertEquals::applyWith(
            '{"true":false,"false":true}',
            TypeAs::applyWith("json")
        )->unfoldUsing(false);
    }

    /**
     * @test
     */
    public function numbers()
    {
        AssertEquals::applyWith(
            true,
            TypeAs::applyWith("boolean")
        )->unfoldUsing(1);

        AssertEquals::applyWith(
            1,
            TypeAs::applyWith("integer")
        )->unfoldUsing(1.0);

        AssertEquals::applyWith(
            1.0,
            TypeAs::applyWith("float")
        )->unfoldUsing(1.0);

        AssertEquals::applyWith(
            [0, 1],
            TypeAs::applyWith("array")
        )->unfoldUsing(1);

        AssertEquals::applyWith(
            [1],
            TypeAs::applyWith("array", 1)
        )->unfoldUsing(1);

        AssertEquals::applyWith(
            ["i0" => 0, "i1" => 1],
            TypeAs::applyWith("dictionary")
        )->unfoldUsing(1.1);

        AssertEquals::applyWith(
            (object) ["i0" => 0, "i1" => 1],
            TypeAs::applyWith("tuple")
        )->unfoldUsing(1.1);

        AssertEquals::applyWith(
            '{"i0":0,"i1":1}',
            TypeAs::applyWith("json")
        )->unfoldUsing(1.1);
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            ["8", "f", "o", "l", "d", "!"],
            TypeAs::applyWith("array")
        )->unfoldUsing("8fold!");

        AssertEquals::applyWith(
            ["8", "old!"],
            TypeAs::applyWith("array", "f", false, 2)
        )->unfoldUsing("8fold!");

        AssertEquals::applyWith(
            ["", "8", "f", "o", "l", "d", ""],
            TypeAs::applyWith("array", "!", true)
        )->unfoldUsing("!8!f!o!l!d!");

        AssertEquals::applyWith(
            true,
            TypeAs::applyWith("boolean")
        )->unfoldUsing("8fold!");

        AssertEquals::applyWith(
            false,
            TypeAs::applyWith("boolean")
        )->unfoldUsing("");

        AssertEquals::applyWith(
            6,
            TypeAs::applyWith("integer")
        )->unfoldUsing("8fold!");

        AssertEquals::applyWith(
            0,
            TypeAs::applyWith("integer")
        )->unfoldUsing("");

        AssertEquals::applyWith(
            ["i0" => "8", "i1" => "8!8"],
            TypeAs::applyWith("dictionary", "!", false, 2)
        )->unfoldUsing("8!8!8");

        AssertEquals::applyWith(
            (object) ["i0" => "8", "i1" => "8!8"],
            TypeAs::applyWith("tuple", "!", false, 2)
        )->unfoldUsing("8!8!8");

        AssertEquals::applyWith(
            '{"efs0":"8","efs1":"8!8"}',
            TypeAs::applyWith("json", "!", false, 2, "efs")
        )->unfoldUsing("8!8!8");

        AssertEquals::applyWith(
            "8fold!",
            TypeAs::applyWith("string")
        )->unfoldUsing(["8", "f", "o", "l", "d", "!"]);
    }

    /**
     * @test
     */
    public function collections()
    {
        AssertEquals::applyWith(
            false,
            TypeAs::applyWith("boolean")
        )->unfoldUsing([]);

        AssertEquals::applyWith(
            3,
            TypeAs::applyWith("integer")
        )->unfoldUsing([0, 1, 2]);

        AssertEquals::applyWith(
            3.0,
            TypeAs::applyWith("float")
        )->unfoldUsing(["a" => 1, "b" => 2, "c" => 3]);

        AssertEquals::applyWith(
            [1, 2, 3],
            TypeAs::applyWith("array")
        )->unfoldUsing(["a" => 1, "b" => 2, "c" => 3]);

        AssertEquals::applyWith(
            ["a" => 1, "b" => 2, "c" => 3],
            TypeAs::applyWith("dictionary")
        )->unfoldUsing(["a" => 1, "b" => 2, "c" => 3]);

        AssertEquals::applyWith(
            (object) ["a" => 1, "b" => 2, "c" => 3],
            TypeAs::applyWith("tuple")
        )->unfoldUsing(["a" => 1, "b" => 2, "c" => 3]);
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
