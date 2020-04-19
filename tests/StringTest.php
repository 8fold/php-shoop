<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Shoop,
    ESString,
    ESArray
};

use Eightfold\Shoop\Tests\TestStrings;

class StringTest extends TestCase
{
    private function plainText(): string
    {
        return 'Hello, World!';
    }

    private function unicode(): string
    {
        return '😀😇🌍😍😌';
    }

    private function plainTextWithUnicode(): string
    {
        return 'Hello, 🌍!';
    }

    public function testWorkflow()
    {
        $this->assertTrue(false);
    }

    public function testToStringMagicMethod()
    {
        $string = "Hello!";
        $expected = "!olleH";
        $actual = Shoop::string($string)->toggle();
        $this->assertEquals($expected, $actual);
    }

    public function testTypeJuggling()
    {
        $string = "Hello!";
        $expected = ["H", "e", "l", "l", "o", "!"];
        $actual = Shoop::string($string)->array();
        $this->assertEquals($expected, $actual->unfold());

        $string = '{"one":2}';
        $actual = Shoop::string($string)->json();
        $this->assertEquals($string, $actual->unfold());
    }

    public function testManipulate()
    {
        $string = "Hello!";
        $expected = "!olleH";
        $actual = Shoop::string($string)->toggle();
        $this->assertEquals($expected, $actual->unfold());

        $expected = "!Hello";
        $string = Shoop::string($string);
        $actual = $string->sort();
        $this->assertEquals($expected, $actual->unfold());

        // $expected = "!eHllo";
        // $actual = $string->sort(true);

        $string = "heLLo";
        $shoopString = Shoop::string($string);
        $result = $shoopString->start("W", "o", "W, ");
        $this->assertEquals("WoW, heLLo", $result->unfold());
    }

    public function testSearch()
    {
        $string = "heLLo";
        $shoopString = Shoop::string($string);

        $actual = $shoopString->startsWith("heL");
        $this->assertTrue($actual->unfold());

        $result = $shoopString->endsWith("Lo");
        $this->assertTrue($result->unfold());
    }

    public function testMathLanguage()
    {
        $hello = ESString::fold("Hello, ");
        $helloWorld = ESString::fold("Hello, World!");

        $result = $hello->plus("🌍!")->unfold();
        $this->assertEquals($this->plainTextWithUnicode(), $result);

        $result = $helloWorld->minus("l")->unfold();
        $this->assertEquals("Heo, Word!", $result);

        $expected = "HelloHelloHello";
        $actual = Shoop::this("Hello", ESString::class)->multiply(3);
        $this->assertEquals($expected, $actual->unfold());

        $compare = ESArray::fold(["He", "o, Wor", "d!"]);
        $actual = ESString::fold("Hello, World!")->divide("l");
        $this->assertTrue($actual->is($compare)->unfold());

        $compare = ESArray::fold(["He", "lo, World!"]);
        $result = Shoop::this("Hello, World!", ESString::class)->split("l");
        $this->assertTrue($result->countUnfolded() == 2);

        $compare = ESArray::fold(["He", "o, World!"]);
        $result = Shoop::this("Hello, World!", ESString::class)->split("l", 3);
        $this->assertTrue($result->countUnfolded() == 3);
    }

    public function testComparison()
    {
        $string1 = "abc";
        $string2 = "cab";
        $actual = Shoop::this($string1, ESString::class)->isLessThanUnfolded($string2);
        $this->assertTrue($actual);

        $string1 = "a";
        $string2 = "b";
        $string3 = "c";
        $actual = Shoop::this($string1, ESString::class)->isLessThan($string2)->and(Shoop::this($string2, ESString::class)->isLessThan($string3));
        $this->assertTrue($actual->unfold());
    }

    public function testOther()
    {
        $base = "HELLO!";
        $expected = "hELLO!";
        $actual = Shoop::this($base, ESString::class)->lowerFirst();
        $this->assertEquals($expected, $actual->unfold());

        $expected = $base;
        $actual = Shoop::this("hello!", ESString::class)->uppercase();
        $this->assertEquals($expected, $actual->unfold());

        $expected = "Hello, 🌍!";

        $actual = Shoop::this(__DIR__, ESString::class)
            ->divide("/")
            ->plus("test.txt")
            ->join("/")
            ->start("/")
            ->pathContent();

        $this->assertEquals($expected, $actual->unfold());
    }

    public function testCanReplaceElements()
    {
        $expected = "hello-world";
        $actual = Shoop::string("hello_world")->replace("_", "-");
        $this->assertEquals($expected, $actual);

        $expected = "herro-worrd";
        $actual = Shoop::string("hello_world")
            ->replace(["_", "l", "rld"], ["-", "r", "rd"]);
        $this->assertEquals($expected, $actual);
    }
}
