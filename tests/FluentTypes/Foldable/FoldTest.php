<?php

namespace Eightfold\Shoop\Tests\Foldable;

use \stdClass;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESDictionary,
    ESInteger,
    ESJson,
    ESTuple,
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

    public function testESBoolean()
    {
        $expected = true;
        $actual = new ESBoolean(true);
        $this->assertSame($expected, $actual->main);

        $actual = new ESBoolean(true);
        $this->assertTrue(is_a($actual, ESBoolean::class));

        $actual = ESBoolean::fold(true);
        $this->assertTrue(is_a($actual, ESBoolean::class));
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

    public function testESInteger()
    {
        $expected = 1;
        $actual = new ESInteger(1);
        $this->assertSame($expected, $actual->main);

        $actual = new ESInteger(1);
        $this->assertTrue(is_a($actual, ESInteger::class));

        $actual = ESInteger::fold(1);
        $this->assertTrue(is_a($actual, ESInteger::class));
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

    public function testESTuple()
    {
        $expected = new stdClass();
        $actual = new ESTuple(new stdClass());
        $this->assertEquals($expected, $actual->main);

        $actual = new ESTuple(new stdClass());
        $this->assertTrue(is_a($actual, ESTuple::class));

        $actual = ESTuple::fold(new stdClass());
        $this->assertTrue(is_a($actual, ESTuple::class));
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
