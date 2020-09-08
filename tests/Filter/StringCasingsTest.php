<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use PHPUnit\Framework\TestCase;
use Eightfold\Foldable\Tests\PerformantEqualsTestFilter as AssertEquals;

use Eightfold\Shoop\Filter\LowerCased;
use Eightfold\Shoop\Filter\UpperCased;

/**
 * @group StringCasings
 */
class StringCasingsTest extends TestCase
{
    /**
     * @test
     */
    public function lowerCased()
    {
        AssertEquals::applyWith(
            "hello! 🎉",
            "string",
            5.35
        )->unfoldUsing(
            LowerCased::apply()->unfoldUsing("HeLLo! 🎉")
        );

        AssertEquals::applyWith(
            "hello! 🎉",
            "string",
            1.98
        )->unfoldUsing(
            LowerCased::apply()->unfoldUsing(
                ["H", 0, new \stdClass, "e", "LL", "o!", " 🎉"]
            )
        );
    }

    /**
     * @test
     */
    public function upperCased()
    {
        AssertEquals::applyWith(
            "HELLO! 🎉",
            "string",
            0.49
        )->unfoldUsing(
            UpperCased::apply()->unfoldUsing("HeLLo! 🎉")
        );

        AssertEquals::applyWith(
            "HELLO! 🎉",
            "string",
            0.38 // 0.36 // 0.33
        )->unfoldUsing(
            UpperCased::apply()->unfoldUsing(
                ["H", 0, new \stdClass, "e", "LL", "o!", " 🎉"]
            )
        );
    }
}
