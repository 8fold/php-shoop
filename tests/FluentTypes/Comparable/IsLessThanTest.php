<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\ESBoolean;

/**
 * @group IsLessThanFluent
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
}
