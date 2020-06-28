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
 * @see Type::is
 *
 * @return Eightfold\Shoop\ESBool After toggling the return of `is()`.
 */
class IsNotTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESInt()
    {
        $base = 10;
        $actual = ESInt::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = "test";
        $actual = ESObject::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESString()
    {
        $base = "alphabet soup";
        $actual = ESString::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESYaml()
    {
        $base = "test: test";
        $actual = ESYaml::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }
}
