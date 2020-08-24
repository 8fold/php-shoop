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
     * @not
     */
    public function ESBoolean()
    {
        // $this->assertFalse(false);
    }

    /**
     * @test
     */
    public function ESInteger()
    {
        // $this->assertFalse(false);
    }

    /**
     * @test
     */
    public function ESString()
    {
        // $base = "Hello, World!";

        // $expected = "World!";
        // $actual = ESString::fold($base)->dropFirst(7);
        // $this->assertEquals($expected, $actual->unfold());

        // $expected = "ello, World!";
        // $actual = Shoop::string($base)->dropFirst();
        // $this->assertEquals($expected, $actual->unfold());

        // $base = "Hello, World!";

        // $expected = "Hello";
        // $actual = ESString::fold($base)->dropLast(8);
        // $this->assertEquals($expected, $actual->unfold());

        // $base = "Hello, World!";

        // $expected = "Hlo ol!";
        // $actual = ESString::fold($base)->drop(1, 3, 5, 7, 9, 11);
        // $this->assertEquals($expected, $actual->unfold());

        // $base = "Hell0, W0rld!";

        // $expected = "Hell,Wrld!";
        // $actual = ESString::fold($base)->noEmpties();
        // $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @test
     */
    public function ESArray()
    {
        // $using = ["hello", "goodbye", "hello"];
        // AssertEqualsFluent::applyWith(
        //     ["goodbye"],
        //     ESArray::class,
        //     3.63
        // )->unfoldUsing(
        //     Shoop::this($using)->minusAt([0, 2])
        // );

        // $base = ["hello", "world"];

        // $expected = [];
        // $actual = Shoop::array($base)->dropFirst(2);
        // $this->assertEquals($expected, $actual->unfold());

        // $base = ["hello", "world"];

        // $expected = [];
        // $actual = Shoop::array($base)->dropLast(2);
        // $this->assertEquals($expected, $actual->unfold());

        // $base = ["hello", "world"];

        // $expected = ["hello"];
        // $actual = Shoop::array($base)->drop(1);
        // $this->assertEquals($expected, $actual->unfold());

        // $base = [0, null];

        // $expected = [];
        // $actual = Shoop::array($base)->noEmpties();
        // $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @test
     */
    public function ESDictionary()
    {
        // $using = ["a" => "hello", "b" => "goodbye", "c" => "hello"];
        // AssertEqualsFluent::applyWith(
        //     ["a" => "hello", "c" => "hello"],
        //     ESDictionary::class
        // )->unfoldUsing(
        //     Shoop::this($using)->minusAt(["b"])
        // );

        // $base = ["member" => "value", "member2" => "value2"];

        // $expected = ["member2" => "value2"];
        // $actual = ESDictionary::fold($base)->dropFirst();
        // $this->assertEquals($expected, $actual->unfold());

        // $base = ["member" => "value", "member2" => "value2"];

        // $expected = ["member" => "value"];
        // $actual = ESDictionary::fold($base)->dropLast();
        // $this->assertEquals($expected, $actual->unfold());

        // $base = ["member" => "value", "member2" => "value2"];

        // $expected = [];
        // $actual = ESDictionary::fold($base)->drop("member", "member2");
        // $this->assertEquals($expected, $actual->unfold());

        // $base = ["member" => false, "member2" => "value2"];

        // $expected = ["member2" => "value2"];
        // $actual = ESDictionary::fold($base)->noEmpties();
        // $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @test
     */
    public function ESJson()
    {
        // $base = '{"member":"value", "member2":"value2", "member3":"value3"}';

        // $expected = '{"member3":"value3"}';
        // $actual = ESJson::fold($base)->dropFirst(2);
        // $this->assertEquals($expected, $actual);

        // $base = '{"member":"value", "member2":"value2", "member3":"value3"}';

        // $expected = '{"member":"value"}';
        // $actual = ESJson::fold($base)->dropLast(2);
        // $this->assertEquals($expected, $actual);

        // $base = '{"member":"value", "member2":"value2", "member3":"value3"}';

        // $expected = '{"member2":"value2"}';
        // $actual = ESJson::fold($base)->drop("member", "member3");
        // $this->assertEquals($expected, $actual);

        // $base = '{"member":false, "member2":"value2", "member3":0}';

        // $expected = '{"member2":"value2"}';
        // $actual = ESJson::fold($base)->noEmpties();
        // $this->assertEquals($expected, $actual);
    }

    public function ESTuple()
    {
        // $base = new \stdClass();
        // $base->testMember = "test";

        // $expected = new \stdClass();
        // $actual = ESTuple::fold($base)->dropFirst();
        // $this->assertEquals($expected, $actual->unfold());

        // $base = new \stdClass();
        // $base->testMember = "test";

        // $expected = new \stdClass();
        // $actual = ESTuple::fold($base)->dropLast();
        // $this->assertEquals($expected, $actual->unfold());

        // $base = new \stdClass();
        // $base->testMember = "test";

        // $expected = new \stdClass();
        // $actual = ESTuple::fold($base)->drop("testMember");
        // $this->assertEquals($expected, $actual->unfold());

        // $base = new \stdClass();
        // $base->testMember = "test";

        // $expected = new \stdClass();
        // $expected->testMember = "test";

        // $actual = ESTuple::fold($base)->noEmpties();
        // $this->assertEquals($expected, $actual->unfold());
    }
}
