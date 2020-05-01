<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\{
    Shoop,
    ESBool,
    ESInt,
    ESString,
    ESArray,
    ESJson
};

use Eightfold\Shoop\Tests\TestObject;

class TypeTest extends TestCase
{
    public function testCanSanitizeTypes()
    {
        $expected = ESInt::class;
        $result = get_class(Type::sanitizeType(10, ESInt::class));
        $this->assertEquals($expected, $result);

        $expected = ESString::class;
        $result = get_class(Type::sanitizeType(10, ESString::class));
        $this->assertEquals($expected, $result);

        $expected = ESArray::class;
        $result = get_class(Type::sanitizeType(10, ESArray::class));
        $this->assertEquals($expected, $result);

        $expected = ESJson::class;
        $result = get_class(Type::sanitizeType('{"@context": "http://schema.org"}', ESJson::class));
        $this->assertEquals($expected, $result);
    }

    public function testCheckTypes()
    {
        $shoop = ESBool::class;
        $php = "bool";

        $this->assertTrue(Type::isPhp(1));
        $this->assertFalse(Type::isPhp(TestObject::class));
        $this->assertTrue(Type::is(1, ESInt::class, "int"));
        $this->assertTrue(Type::is(1, "int", ESInt::class));
        $this->assertEquals("int", Type::for(1));
        $this->assertEquals(ESInt::class, Type::shoopFor(1));
        $this->assertEquals(ESInt::class, get_class(Shoop::int(1)));

        $result = Type::for(Shoop::bool(true));
        $this->assertEquals($shoop, $result);

        $result = Type::for(true);
        $this->assertEquals($php, $result);

        $result = Type::isShooped(ESBool::fold(true));
        $this->assertTrue($result);

        $result = Type::isPhp($php);
        $this->assertTrue($result);

        $array = [1, 2, 3];
        $result = Type::isArray($array);
        $this->assertTrue($result);

        $result = Type::isArray(Shoop::array($array));
        $this->assertTrue($result);

        $result = Type::isEmpty(Shoop::array([]));
        $this->assertTrue($result);

        $result = Type::isDictionary(
            Shoop::dictionary(["one" => 1, "two" => 2])
        );
        $this->assertTrue($result);

        $result = Type::isDictionary(
            Shoop::array([1, 2])
        );
        $this->assertFalse($result);

        $result = Type::isDictionary(
            ["one" => 1, "two" => 2]
        );
        $this->assertTrue($result);

        $result = Type::isDictionary(
            [1, 2]
        );
        $this->assertFalse($result);

        $result = Type::isDictionary(
            Shoop::string("Hello!")
        );
        $this->assertFalse($result);

        $result = Type::isDictionary(
            "Hello!"
        );
        $this->assertFalse($result);

        // $result = Type::isPath("/Users/server/public/folder");
        // $this->assertTrue($result);

        // $result = Type::isPath("http://8fold.software");
        // $this->assertFalse($result);

        // $result = Type::isUri("http://8fold.software");
        // $this->assertTrue($result);
    }

    public function testCanGetTypeFromType()
    {
        $shoop = ESBool::class;
        $php = "bool";

        $map = Type::map();
        $result = $map[$php];
        $this->assertEquals($shoop, $result);

        $result = array_search($shoop, $map);
        $this->assertEquals($php, $result);

        $result = Type::phpToShoop("bool");
        $this->assertEquals($shoop, $result);

        $result = Type::shoopToPhp($shoop);
        $this->assertEquals($php, $result);
    }

    public function testCanCheckStringIsJson()
    {
        $actual = Type::isJson("");
        $this->assertFalse($actual);

        $actual = Type::isJson("{");
        $this->assertFalse($actual);
    }
}
