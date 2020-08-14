<?php

namespace Eightfold\Shoop\Tests\Foldable;

use \stdClass;

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
    ESString
};

/**
 * The `fold()` static method is an alias for the common constructor. If the given type can be derived, it will be instantiated as the Shoop type equivalent.
 *
 * Note: The `PHP type` should be equivalent to the `Shoop type`.
 */
class FoldTest extends TestCase
{
    public function testESArray()
    {
        $expected = [];
        $actual = new ESArray([]);
        $this->assertSame($expected, $actual->main);

        $actual = new ESArray(['testing']);
        $this->assertTrue(is_a($actual, ESArray::class));

        $actual = ESArray::fold(['testing']);
        $this->assertTrue(is_a($actual, ESArray::class));
    }

    public function testESBool()
    {
        $expected = true;
        $actual = new ESBool(true);
        $this->assertSame($expected, $actual->main);

        $actual = new ESBool(true);
        $this->assertTrue(is_a($actual, ESBool::class));

        $actual = ESBool::fold(true);
        $this->assertTrue(is_a($actual, ESBool::class));
    }

    public function testESDictionary()
    {
        $expected = [];
        $actual = new ESDictionary([]);
        $this->assertSame($expected, $actual->main);

        $actual = new ESDictionary([]);
        $this->assertTrue(is_a($actual, ESDictionary::class));

        $actual = ESDictionary::fold([]);
        $this->assertTrue(is_a($actual, ESDictionary::class));
    }

    public function testESInt()
    {
        $expected = 1;
        $actual = new ESInt(1);
        $this->assertSame($expected, $actual->main);

        $actual = new ESInt(1);
        $this->assertTrue(is_a($actual, ESInt::class));

        $actual = ESInt::fold(1);
        $this->assertTrue(is_a($actual, ESInt::class));
    }

    public function testESJson()
    {
        $expected = '{}';
        $actual = new ESJson('{}');
        $this->assertSame($expected, $actual->main);

        $actual = new ESJson('{"test":"test"}');
        $this->assertTrue(is_a($actual, ESJson::class));

        $actual = ESJson::fold('{"test":"test"}');
        $this->assertTrue(is_a($actual, ESJson::class));
    }

    public function testESObject()
    {
        $expected = new stdClass();
        $actual = new ESObject(new stdClass());
        $this->assertEquals($expected, $actual->main);

        $actual = new ESObject(new stdClass());
        $this->assertTrue(is_a($actual, ESObject::class));

        $actual = ESObject::fold(new stdClass());
        $this->assertTrue(is_a($actual, ESObject::class));
    }

    public function testESString()
    {
        $expected = "";
        $actual = new ESString("");
        $this->assertSame($expected, $actual->main);

        $actual = new ESString("");
        $this->assertTrue(is_a($actual, ESString::class));

        $actual = ESString::fold("");
        $this->assertTrue(is_a($actual, ESString::class));
    }
}
