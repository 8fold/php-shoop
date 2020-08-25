<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

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
            LowerCased::apply(),
            1.95
        )->unfoldUsing("HeLLo! 🎉");

        AssertEquals::applyWith(
            "hello! 🎉",
            LowerCased::apply()
        )->unfoldUsing(["H", 0, new \stdClass, "e", "LL", "o!", " 🎉"]);
    }

    /**
     * @test
     */
    public function upperCased()
    {
        AssertEquals::applyWith(
            "HELLO! 🎉",
            UpperCased::apply()
        )->unfoldUsing("HeLLo! 🎉");

        AssertEquals::applyWith(
            "HELLO! 🎉",
            UpperCased::apply()
        )->unfoldUsing(["H", 0, new \stdClass, "e", "LL", "o!", " 🎉"]);
    }
}
