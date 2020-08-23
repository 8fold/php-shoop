<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;
use Eightfold\Shoop\Tests\AssertEqualsFluent;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\ESBoolean;

/**
 * @group IsEmptyFluent
 */
class IsEmptyTest extends TestCase
{
    /**
     * @test
     */
    public function ESBool()
    {
        $compare = true;
        AssertEqualsFluent::applyWith(
            false,
            ESBoolean::class,
            2.3
        )->unfoldUsing(
            Shoop::this(true)->isEmpty()
        );

        AssertEqualsFluent::applyWith(
            true,
            ESBoolean::class
        )->unfoldUsing(
            Shoop::this(false)->isEmpty()
        );
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        AssertEqualsFluent::applyWith(
            false,
            ESBoolean::class
        )->unfoldUsing(
            Shoop::this(1)->isEmpty()
        );
    }

    /**
     * @test
     */
    public function ESString()
    {
        $compare = "8fold!";
        AssertEqualsFluent::applyWith(
            true,
            ESBoolean::class
        )->unfoldUsing(
            Shoop::this("8fold!")->isEmpty($compare)
        );
    }

    /**
     * @test
     */
    public function ESArray()
    {
        AssertEqualsFluent::applyWith(
            false,
            ESBoolean::class
        )->unfoldUsing(
            Shoop::this([1, 2, 3])->isEmpty()
        );
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        AssertEqualsFluent::applyWith(
            false,
            ESBoolean::class
        )->unfoldUsing(
            Shoop::this(["a" => 1, "b" => 2, "c" => 3])->isEmpty()
        );
    }

    /**
     * @test
     */
    public function ESTuple()
    {
        AssertEqualsFluent::applyWith(
            true,
            ESBoolean::class,
            0.68
        )->unfoldUsing(
            Shoop::this(new class {})->isEmpty()
        );

        AssertEqualsFluent::applyWith(
            false,
            ESBoolean::class
        )->unfoldUsing(
            Shoop::this('{"a":1,"b":2,"c":3}')->isEmpty($compare)
        );
    }

    // public function ESArray()
    // {
    //     $base = ["hello", "world"];
    //     $actual = ESArray::fold($base)->isEmpty();
    //     $this->assertFalse($actual->unfold());

    //     $actual = ESArray::fold($base)->isEmpty(function($result, $value) {
    //         if (! $result->unfold()) {
    //             return Shoop::string($value->last);
    //         }
    //     });
    //     $this->assertEquals("world", $actual->unfold());

    //     $base = [];
    //     $actual = ESArray::fold($base)->isEmpty();
    //     $this->assertTrue($actual->unfold());

    //     $actual = ESArray::fold($base)->isEmpty(function($result, $value) {
    //         if ($result) {
    //             return Shoop::string("");
    //         }
    //     });
    //     $this->assertEquals("", $actual->unfold());
    // }

    // public function ESBoolean()
    // {
    //     $base = true;
    //     $actual = ESBoolean::fold($base)->isEmpty();
    //     $this->assertFalse($actual->unfold());

    //     $base = false;
    //     $actual = ESBoolean::fold($base)->isEmpty();
    //     $this->assertTrue($actual->unfold());
    // }

    // public function ESDictionary()
    // {
    //     $base = ["member" => "value"];
    //     $actual = ESDictionary::fold($base)->isEmpty();
    //     $this->assertFalse($actual->unfold());
    // }

    // public function ESInteger()
    // {
    //     $base = 0;
    //     $actual = ESInteger::fold($base)->isEmpty();
    //     $this->assertTrue($actual->unfold());

    //     $base = 10;
    //     $actual = ESInteger::fold($base)->isEmpty();
    //     $this->assertFalse($actual->unfold());

    //     $base = -1;
    //     $actual = ESInteger::fold($base)->isEmpty();
    //     $this->assertFalse($actual->unfold());
    // }

    // /**
    //  * Uses `object()` then checks if the ESTuple `isEmpty()` (no members).
    //  */
    // public function ESJson()
    // {
    //     $base = '{}';
    //     $actual = ESJson::fold($base)->isEmpty();
    //     $this->assertTrue($actual->unfold());

    //     $base = '{"test":"test"}';
    //     $actual = ESJson::fold($base)->isEmpty();
    //     $this->assertFalse($actual->unfold());
    // }

    // /**
    //  * Uses `dictionary()` then checks if the ESDictionary `isEmpty()`
    //  */
    // public function ESTuple()
    // {
    //     $base = new \stdClass();
    //     $base->test = "test";
    //     $actual = ESTuple::fold($base)->isEmpty();
    //     $this->assertFalse($actual->unfold());
    // }

    // public function ESString()
    // {
    //     $base = "alphabet soup";
    //     $actual = ESString::fold($base)->isEmpty();
    //     $this->assertFalse($actual->unfold());

    //     $base = "";
    //     $actual = ESString::fold($base)->isEmpty();
    //     $this->assertTrue($actual->unfold());
    // }
}
