<?php

namespace Eightfold\Shoop\Tests\PipeFilters;

use Eightfold\Shoop\Tests\TestCase;
use Eightfold\Shoop\Tests\AssertEquals;

use \stdClass;

use Eightfold\Shoop\PipeFilters\Minus;

/**
 * @group MinusAt
 */
class MinusAtTest extends TestCase
{
    /**
     * @test
     */
    public function boolean()
    {
        // AssertEquals::applyWith(
        //     true,
        //     Minus::apply(),
        //     3.29 //very inconsistant - less than 1
        // )->unfoldUsing(true);

        // AssertEquals::applyWith(
        //     false,
        //     Minus::applyWith(1)
        // )->unfoldUsing(true);

        // AssertEquals::applyWith(
        //     true,
        //     Minus::applyWith(2)
        // )->unfoldUsing(true);
    }

    /**
     * @test
     */
    public function number()
    {
        // AssertEquals::applyWith(
        //     1,
        //     Minus::apply()
        // )->unfoldUsing(1);

        // AssertEquals::applyWith(
        //     0,
        //     Minus::applyWith(1)
        // )->unfoldUsing(1);

        // AssertEquals::applyWith(
        //     -2.7,
        //     Minus::applyWith(1.5)
        // )->unfoldUsing(-1.2);

        // AssertEquals::applyWith(
        //     1,
        //     Minus::applyWith(-6.5)
        // )->unfoldUsing(-5.5);
    }

    /**
     * @test
     */
    public function lists()
    {
        // AssertEquals::applyWith(
        //     [1, true],
        //     Minus::applyWith("string"),
        //     0.49
        // )->unfoldUsing([1, "string", true]);

        // AssertEquals::applyWith(
        //     ["stringKey" => "string"],
        //     Minus::applyWith([true, 1])
        // )->unfoldUsing(["one" => 1, "stringKey" => "string", "true" => true]);
    }

    /**
     * @test
     */
    public function string()
    {
        // $using = "  Do you remember when, we used to sing?  ";

        // AssertEquals::applyWith(
        //     "Do you remember when, we used to sing?",
        //     Minus::apply(),
        //     1.06
        // )->unfoldUsing($using);

        // AssertEquals::applyWith(
        //     "Do you remember when, we used to sing?  ",
        //     Minus::applyWith(true, false)
        // )->unfoldUsing($using);

        // AssertEquals::applyWith(
        //     "  Do you remember when, we used to sing?",
        //     Minus::applyWith(false, true)
        // )->unfoldUsing($using);

        // AssertEquals::applyWith(
        //     "Doyourememberwhen,weusedtosing?",
        //     Minus::applyWith(false, false)
        // )->unfoldUsing($using);

        // AssertEquals::applyWith(
        //     "Dyrmmbrwhn,wsdtsng?",
        //     Minus::applyWith(false, false, [" ", "a", "e", "i", "o", "u"])
        // )->unfoldUsing($using);
    }

    /**
     * @test
     */
    public function from_tuples()
    {
        // $using = (object) ["one" => 1, "stringKey" => "string", "true" => true];

        // AssertEquals::applyWith(
        //     (object) ["one" => 1, "true" => true],
        //     Minus::applyWith("string"),
        //     1.17
        // )->unfoldUsing($using);

        // AssertEquals::applyWith(
        //     (object) ["stringKey" => "string"],
        //     Minus::applyWith([1, true])
        // )->unfoldUsing($using);
    }

    // public function ESArray()
    // {
    //     $actual = ESArray::fold([false, true]);
    //     $actual->offsetUnset(0);
    //     $this->assertTrue($actual->getUnfolded(1));
    // }

    // /**
    //  * No changes made.
    //  */
    // public function ESBoolean()
    // {
    //     $actual = ESBoolean::fold(true);
    //     $actual->offsetUnset(0);
    //     $this->assertTrue($actual->unfold());
    // }

    // public function ESDictionary()
    // {
    //     $actual = ESDictionary::fold(["member" => false]);
    //     $actual->offsetUnset("member");
    //     $this->assertFalse($actual->offsetExists("member"));
    // }

    // /**
    //  * No changes made.
    //  */
    // public function ESInteger()
    // {
    //     $actual = ESInteger::fold(10);
    //     $actual->offsetUnset(8);
    //     $this->assertEquals(10, $actual->unfold());
    // }

    // public function ESJson()
    // {
    //     $expected = '{}';
    //     $actual = ESJson::fold('{"test":true}');
    //     $actual->offsetUnset("test");
    //     $this->assertEquals($expected, $actual->unfold());
    // }

    // public function ESTuple()
    // {
    //     $base = new \stdClass();
    //     $base->test = false;

    //     $actual = ESTuple::fold($base);
    //     $actual->offsetUnset("test");
    //     $this->assertFalse($actual->offsetExists("test"));
    // }

    // public function ESString()
    // {
    //     $expected = "cop";
    //     $actual = ESString::fold("comp");
    //     $actual->offsetUnset(2);
    //     $this->assertEquals($expected, $actual);
    // }
}
