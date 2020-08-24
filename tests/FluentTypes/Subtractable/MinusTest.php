<?php

namespace Eightfold\Shoop\Tests\MathOperations;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\ESBoolean;
use Eightfold\Shoop\FluentTypes\ESArray;
use Eightfold\Shoop\FluentTypes\ESDictionary;

/**
 * @group MinusFluent
 *
 * The `minus()` method for most `Shoop types` unsets or removes the specified members.
 */
class MinusTest extends TestCase
{
    /**
     * @test
     */
    public function ESArray()
    {
        $using = ["hello", "goodbye", "hello"];
        AssertEqualsFluent::applyWith(
            ["goodbye"],
            ESArray::class,
            3.63
        )->unfoldUsing(
            Shoop::this($using)->minusMembers([0, 2])
        );
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        $using = ["a" => "hello", "b" => "goodbye", "c" => "hello"];
        AssertEqualsFluent::applyWith(
            ["a" => "hello", "c" => "hello"],
            ESDictionary::class
        )->unfoldUsing(
            Shoop::this($using)->minusMembers(["b"])
        );
    }
}
