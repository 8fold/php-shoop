<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use \stdClass;

use Eightfold\Shoop\PipeFilters\Reversed;

/**
 * @group Reversed
 */
class ReversedTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            true,
            Reversed::apply(),
            1.31
        )->unfoldUsing(false);
    }

    /**
     * @test
     */
    public function list()
    {
        AssertEquals::applyWith(
            [3, 2, 1],
            Reversed::apply()
        )->unfoldUsing([1, 2, 3]);

        AssertEquals::applyWith(
            ["c" => 3, "b" => 2, "a" => 1],
            Reversed::apply()
        )->unfoldUsing(["a" => 1, "b" => 2, "c" => 3]);
    }

    /**
     * @test
     */
    public function number()
    {
        AssertEquals::applyWith(
            -1,
            Reversed::apply()
        )->unfoldUsing(1);
    }

    /**
     * @test
     */
    public function string()
    {
        AssertEquals::applyWith(
            "!dlof8",
            Reversed::apply()
        )->unfoldUsing("8fold!");
    }

    /**
     * @test
     */
    public function tuple()
    {
        AssertEquals::applyWith(
            (object) ["first" => true, "last" => false],
            Reversed::apply(),
            3.93
        )->unfoldUsing((object) ["last" => false, "first" => true]);
    }

    /**
     * @test
     */
    public function object()
    {
        $using = new class {
            public $public = "content";
            public $public2 = "content2";
            private $private;

            public function __construct()
            {
                $this->private = "content";
            }
        };

        AssertEquals::applyWith(
            (object) ["public2" => "content2", "public" => "content"],
            Reversed::apply(),
            0.94 // same as tuple, so pretty wide performance
        )->unfoldUsing($using);
    }

    /**
     * @test
     */
    public function json()
    {
        AssertEquals::applyWith(
            '{"member2":2,"member":1}',
            Reversed::apply(),
            1.27
        )->unfoldUsing('{"member":1,"member2":2}');
    }
}
