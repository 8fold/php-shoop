<?php

namespace Eightfold\Shoop\Tests\Wrap;

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

class TypeTest extends TestCase
{
    public function testSanitizeType()
    {
        $base = 3;

        // $actual = Type::sanitizeType($base);
        // $this->assertEquals(ESInt::class, get_class($actual));

        // $expected = Shoop::array([]);
        // $actual = Type::sanitizeType($expected);
        // $this->assertEquals($expected, $actual);

        $expected = [0, 1, 2, 3];
        $actual = Type::sanitizeType($base, ESArray::class);
        $this->assertEquals($expected, $actual->unfold());

        $expected = Shoop::array(["h", "i"]);
        $actual = Type::sanitizeType("hi", ESArray::class);
        $this->assertEquals($expected, $actual);
    }

    public function testIsShooped()
    {
        $actual = Type::isShooped(false);
        $this->assertFalse($actual);

        $base = Shoop::array([]);
        $actual = Type::isShooped($base);
        $this->assertTrue($actual);
    }
}
