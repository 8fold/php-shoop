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

    public function testReadMeExample()
    {
        $string = "Hello!";
        $shoop = Shoop::string($string);
        $result = $shoop->array()->first();
        $this->assertEquals("H", $result);

        $result = $shoop[0];
        $this->assertEquals("H", $result);

        $result = $shoop->first();
        $this->assertEquals("H", $result);
    }

    public function testCanInitializeWithString()
    {
        $expected = $this->plainTextWithUnicode();
        $result = ESString::fold($this->plainTextWithUnicode());
        $this->assertEquals($expected, $result->unfold());
    }

    public function testCanCreateBasicDataTypes()
    {
        $result = Shoop::int(1)->unfold();
        $this->assertEquals(1, $result);

        $result = Shoop::string("Hello!")->unfold();
        $this->assertEquals("Hello!", $result);

        $result = Shoop::array([1, 2, 3, 4, 5])->unfold();
        $this->assertEquals([1, 2, 3, 4, 5], $result);
    }

    public function testCanAppendStringWithString()
    {
        $expected = '🌍,🌍,🌍,🌍,🌍,';
        $result = ESString::fold('🌍,')
            ->multiply(5)
            ->unfold();
        $this->assertEquals($expected, $result);
    }

    public function testCanCountCharacters()
    {
        $expected = 9;
        $result = ESString::fold($this->plainTextWithUnicode())->count()->unfold();
        $this->assertEquals($expected, $result);
    }

    public function testCanCheckEquality()
    {
        $compare = $this->unicode();
        $result = ESString::fold($compare)
            ->isSame(ESString::fold($compare));
        $this->assertTrue($result->unfold());
    }

    public function testCanCheckEqualityFails()
    {
        $compare = ESString::fold('H');
        $result = ESString::fold($this->unicode())
            ->isSame($compare);
        $this->assertFalse($result->unfold());
    }

    // TODO: Write tests for random character

    public function testCanDoPlusAndMinus()
    {
        $hello = ESString::fold("Hello, ");
        $helloWorld = ESString::fold("Hello, World!");
        $result = $hello->plus("🌍!")->unfold();
        $this->assertEquals($this->plainTextWithUnicode(), $result);

        $result = $helloWorld->minus("l")->unfold();
        $this->assertEquals("Heo, Word!", $result);

        $result = $hello->end("World!");
        $this->assertEquals($helloWorld, $result);

        $result = ESString::fold(", World!")->prependUnfolded("Hello");
        $this->assertEquals($helloWorld, $result);
    }

    public function testCanCountContents()
    {
        $string = ESString::fold("Hello!");
        $result = $string->count()->unfold();
        $this->assertEquals(6, $result);

        $result = $string->enumerate()->count()->unfold();
        $this->assertEquals(6, $result);

        $result = $string->count()->isGreaterThanUnfolded(0);
        $this->assertTrue($result);

        $result = $string->count()->isLessThanOrEqual(8)->unfold();
        $this->assertTrue($result);

        $result = $string->count()->isLessThanUnfolded(5);
        $this->assertFalse($result);

        $result = $string->count()->isGreaterThanOrEqualUnfolded(7);
        $this->assertFalse($result);
    }

    public function testCanBeDvidedBy()
    {
        $compare = ESArray::fold(["He", "o, Wor", "d!"]);
        $shoopString = ESString::fold("Hello, World!");
        $result = $shoopString->divide("l");
        $this->assertTrue($result->isSame($compare)->unfold());

        $compare = ESArray::fold(["He", "lo, World!"]);
        $result = $shoopString->split("l");
        $this->assertTrue($result->countUnfolded() == 2);

        $compare = ESArray::fold(["He", "o, World!"]);
        $result = $shoopString->split("l", 3);
        $this->assertTrue($result->countUnfolded() == 3);
    }

    public function testDoesBeginOrEndWith()
    {
        $helloWorld = ESString::fold("Hello, World!");
        $result = $helloWorld->beginsWithUnfolded("Hello");
        $this->assertTrue($result);

        $result = $helloWorld->endsWithUnfolded("World!");
        $this->assertTrue($result);
    }

    public function testCanUseESStringAsPhpString()
    {
        $hello = ESString::fold("Hello");
        $helloWorld = $hello .", World!";
        $this->assertEquals("Hello, World!", $helloWorld);
    }

    public function testCanUseAsPhpObject()
    {
        $expected = (object) "hello";
        $result = ESString::fold("hello")->objectUnfolded();
        $this->assertEquals($expected, $result);
    }

    public function testCanBeUsedAsInteger()
    {
        $expected = 5;
        $result = ESString::fold("hello")->intUnfolded();
        $this->assertEquals($expected, $result);
    }

    public function testCanCheckForContains()
    {
        $string = "heLLo";
        $shoopString = Shoop::string($string);
        $result = $shoopString->contains("L");
        $this->assertTrue($result->unfold());

        $result = $shoopString->startsWith("heL");
        $this->assertTrue($result->unfold());

        $result = $shoopString->doesNotStartWith("zoo");
        $this->assertTrue($result->unfold());

        $result = $shoopString->endsWith("Lo");
        $this->assertTrue($result->unfold());

        $result = $shoopString->start("W", "o", "W, ");
        $this->assertEquals("WoW, heLLo", $result->unfold());
    }
}
