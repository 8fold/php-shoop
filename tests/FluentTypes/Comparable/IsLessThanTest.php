<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\ESBoolean;

/**
 * @group IsLessThanFluent
 * @group IsLessThanOrEqualToFluent
 */
class IsLessThanTest extends TestCase
{
    /**
     * @test
     */
    public function ESBoolean()
    {
        $compare = false;
        AssertEqualsFluent::applyWith(
            false,
            ESBoolean::class,
            5.55
        )->unfoldUsing(
            Shoop::this(true)->isLessThan($compare)
        );

        $compare = true;
        AssertEqualsFluent::applyWith(
            true,
            ESBoolean::class
        )->unfoldUsing(
            Shoop::this(false)->isLessThan($compare)
        );
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        $compare = (object) ["a" => 2, "b" => 3, "c" => 4];
        AssertEqualsFluent::applyWith(
            true,
            ESBoolean::class,
            2.77
        )->unfoldUsing(
            Shoop::this((object) ["a" => 2, "b" => 3, "c" => 4])
                ->isLessThanOrEqualTo($compare)
        );
    }
}
