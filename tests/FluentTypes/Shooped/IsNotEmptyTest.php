<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESDictionary,
    ESInteger,
    ESJson,
    ESObject,
    ESString
};
/**
 * @see Eightfold\Shoop\Helpers\Type::isNotEmpty
 */
class IsNotEmptyTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->isNotEmpty();
        $this->assertTrue($actual->unfold());

        $actual = ESArray::fold($base)->isNotEmpty(function($result, $value) {
                if ($result) {
                    return Shoop::string($value->first);
                }
            });
        $this->assertEquals("hello", $actual->unfold());

        $base = [];
        $actual = ESArray::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());

        $actual = ESArray::fold($base)
            ->isNotEmpty(function($result, $value) {
                return $result;
            });
        $this->assertFalse($actual->unfold());

    }

    public function testESBoolean()
    {
        $base = true;
        $actual = ESBoolean::fold($base)->isNotEmpty();
        $this->assertTrue($actual->unfold());

        $base = false;
        $actual = ESBoolean::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = [];
        $actual = ESDictionary::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());
    }

    public function testESInteger()
    {
        $base = 0;
        $actual = ESInteger::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());

        $base = 10;
        $actual = ESInteger::fold($base)->isNotEmpty();
        $this->assertTrue($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{}';
        $actual = ESJson::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());

        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->isNotEmpty();
        $this->assertTrue($actual->unfold());
    }

    public function testESObject()
    {
        $base = new \stdClass();
        $base->test = "test";
        $actual = ESObject::fold($base)->isNotEmpty();
        $this->assertTrue($actual->unfold());
    }

    public function testESString()
    {
        $base = "alphabet soup";
        $actual = ESString::fold($base)->isNotEmpty();
        $this->assertTrue($actual->unfold());

        $base = "";
        $actual = ESString::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());
    }
}
