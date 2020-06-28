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
 * @see Type::isNotEmpty
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

    public function testESBool()
    {
        $base = true;
        $actual = ESBool::fold($base)->isNotEmpty();
        $this->assertTrue($actual->unfold());

        $base = false;
        $actual = ESBool::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = [];
        $actual = ESDictionary::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());
    }

    public function testESInt()
    {
        $base = 0;
        $actual = ESInt::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());

        $base = 10;
        $actual = ESInt::fold($base)->isNotEmpty();
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

    public function testESYaml()
    {
        $base = '';
        $actual = ESYaml::fold($base)->isNotEmpty();
        $this->assertFalse($actual->unfold());

        $base = "test: test";
        $actual = ESYaml::fold($base)->isNotEmpty();
        $this->assertTrue($actual->unfold());
    }
}
