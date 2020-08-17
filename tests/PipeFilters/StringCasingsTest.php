<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;

use \stdClass;

use Eightfold\Shoop\PipeFilters\AsStringLowerCased;
use Eightfold\Shoop\PipeFilters\AsStringUpperCased;

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
        $sut = "HeLLo! 🎉";

        $expected = "hello! 🎉";

        $actual = AsStringLowerCased::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual, 0.9);

        $this->start = hrtime(true);
        $sut = ["H", 0, new \stdClass, "e", "LL", "o!", " 🎉"];

        $expected = "hello! 🎉";

        $actual = AsStringLowerCased::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual, 1.05);
    }

    /**
     * @test
     */
    public function upperCased()
    {
        $sut = "HeLLo! 🎉";

        $expected = "HELLO! 🎉";

        $actual = AsStringUpperCased::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual, 1);

        $this->start = hrtime(true);
        $sut = ["H", 0, new \stdClass, "e", "LL", "o!", " 🎉"];

        $expected = "HELLO! 🎉";

        $actual = AsStringUpperCased::apply()->unfoldUsing($sut);
        $this->assertEqualsWithPerformance($expected, $actual, 0.9);
    }
}
