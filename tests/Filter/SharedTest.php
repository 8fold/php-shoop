<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Filter\Shared;

/**
 * @group Shared
 */
class SharedTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        AssertEquals::applyWith(
            [true, false],
            "array",
            0.89,
            61 // 60
        )->unfoldUsing(
            Shared::applyWith(true)->unfoldUsing(false)
        );
    }

    /**
     * @test
     */
    public function lists()
    {
        $using = [3, 2, 5, 4];

        AssertEquals::applyWith(
            [3, 5],
            "array",
            1.22, // 1.04, // 0.98,
            61 // 60
        )->unfoldUsing(
            Shared::applyWith([3, 5])->unfoldUsing($using)
        );

        AssertEquals::applyWith(
            ["a" => 1, "c" => 3],
            "array",
            0.3,
            12
        )->unfoldUsing(
            Shared::applyWith([1, 3])->unfoldUsing(["a" => 1, "b" => 2, "c" => 3, "d" => 4])
        );
    }

    /**
     * @test
     */
    public function strings()
    {
        AssertEquals::applyWith(
            ["a", "s", "a", "s", "s"],
            "array",
            1.11, // 0.98, // 0.97, // 0.95, // 0.77
            62
        )->unfoldUsing(
            Shared::applyWith(["a", "s"])->unfoldUsing("So, raise your glass!")
        );
    }

    /**
     * @test
     */
    public function tuples()
    {
        $using = new class {
            public $public = "content";
            public $public2 = 2;
            public $public3 = false;
        };

        AssertEquals::applyWith(
            ["public" => "content"],
            "array",
            1.13, // 1.08, // 1.07,
            58
        )->unfoldUsing(
            Shared::applyWith("content")->unfoldUsing($using)
        );

        AssertEquals::applyWith(
            ["member" => true, "member2" => false],
            "array",
            1.47, // 1.09
            81
        )->unfoldUsing(
            Shared::applyWith(false)->unfoldUsing('{"member":true,"member2":false}')
        );

        AssertEquals::applyWith(
            ["member2" => false],
            "array"
        )->unfoldUsing(
            Shared::applyWith([false])->unfoldUsing('{"member":true,"member2":false}')
        );
    }
}
