<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString,
    ESYaml
};

/**
 * The `unfold()` method return `PHP type` value of the `Shoop type`.
 */
class UnfoldTest extends TestCase
{
    /**
     * @return array
     */
    public function testESArray()
    {
        $expected = ["testing"];
        $actual = new ESArray($expected);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESArray::fold($expected);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return bool
     */
    public function testESBool()
    {
        $expected = true;
        $actual = new ESBool(true);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESBool::fold(true);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return array (associative)
     */
    public function testESDictionary()
    {
        $expected = ["hello" => "world"];
        $actual = new ESDictionary($expected);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESDictionary::fold($expected);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return integer
     */
    public function testESInt()
    {
        $expected = 1;
        $actual = new ESInt($expected);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESInt::fold($expected);
        $this->assertEquals($expected, $actual->unfold());

        $expected = 1;
        $actual = ESInt::fold(1.1);
        $this->assertEquals($expected, $actual->unfold());

        $expected = 0;
        $actual = ESInt::fold("hello");
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return string
     */
    public function testESJson()
    {
        $expected = '{"test":"test"}';
        $actual = new ESJson($expected);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESJson::fold($expected);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return stdClass
     */
    public function testESObject()
    {
        $expected = new \stdClass();
        $actual = new ESObject($expected);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESObject::fold($expected);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return string
     */
    public function testESString()
    {
        $expected = "hello";
        $actual = new ESString($expected);
        $this->assertEquals($expected, $actual->unfold());

        $actual = ESString::fold($expected);
        $this->assertEquals($expected, $actual->unfold());
    }

    /**
     * @return string
     */
    public function testESYaml()
    {
        $base = <<<EOD
        ---
        hello
        ---
        EOD;
        $actual = new ESYaml($expected);
        $this->assertEquals($base, $actual->unfold());

        // $actual = ESYaml::fold($expected);
        // $this->assertEquals($base, $actual->unfold());

        // $expected = "hello";
        // $actual = Shoop::yaml($base)->value();
        // $this->assertEquals($expected, $actual->unfold());
    }
}
