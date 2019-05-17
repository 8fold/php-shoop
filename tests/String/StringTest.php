<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESString;

use Eightfold\Shoop\Tests\String\TestStrings;

class StringTest extends TestCase
{
    use TestStrings;

    public function testCanDropFirstCount()
    {
        $expected = '🌍😍😌';
        $result = ESString::wrap($this->unicode())
            ->dropFirst(2);
        $this->assertEquals($expected, $result->unwrap());
    }

    public function testCanDropLastCount()
    {
        $expected = '😀😇🌍';
        $result = ESString::wrap($this->unicode())
            ->dropLast(2);
        $this->assertEquals($expected, $result->unwrap());
    }

    public function testCanGetLowercasedString()
    {
        $expected = 'hello, 🌍!';
        $string = ESString::wrap($this->plainTextWithUnicode());
        $result = $string->lowercased();
        $this->assertEquals($expected, $result);
        $this->assertEquals($this->plainTextWithUnicode(), $string->unwrap());
    }

    public function testCanGetUppercasedString()
    {
        $expected = 'HELLO, 🌍!';
        $string = ESString::wrap($this->plainTextWithUnicode());
        $result = $string->uppercased();
        $this->assertEquals($expected, $result);
        $this->assertEquals($this->plainTextWithUnicode(), $string->unwrap());
    }

    public function testCanRetrieveFirstCharacterPlaintext()
    {
        $expected = 'H';
        $result = ESString::wrap($this->plainText())->first()->unwrap();
        $this->assertEquals($expected, $result);
    }

    public function testCanRetrieveFirstCharacterUnicode()
    {
        $expected = '😀';
        $result = ESString::wrap($this->unicode())->first()->unwrap();
        $this->assertEquals($expected, $result);
    }

    public function testCanRetrieveLastCharacterPlaintext()
    {
        $expected = '!';
        $result = ESString::wrap($this->plainText())->last()->unwrap();
        $this->assertEquals($expected, $result);
    }

    public function testCanRetrieveLastCharacterUnicode()
    {
        $expected = '😌';
        $result = ESString::wrap($this->unicode())->last()->unwrap();
        $this->assertEquals($expected, $result);
    }

    // TODO: Write tests for random character

    public function testCanSortString()
    {
        $expected = [
            ' ',
            '!',
            ',',
            'H',
            'e',
            'l',
            'l',
            'o',
            '🌍'
        ];
        $result = ESString::wrap($this->plainTextWithUnicode())->sorted()->unwrap();
        $this->assertEquals(implode('', $expected), $result);
    }

    public function testStringContainsString()
    {
        $result = ESString::wrap("Hello, World!");
        $this->assertTrue($result->contains(", ")->unwrap());
        $this->assertFalse($result->contains("?")->unwrap());
    }

    public function testCanDoPlusAndMinus()
    {
        $result = ESString::wrap("Hello, ")->plus("🌍!")->unwrap();
        $this->assertEquals($this->plainTextWithUnicode(), $result);

        $result = ESString::wrap("Hello, World!")->minus("l")->unwrap();
        $this->assertEquals("Heo, Word!", $result);
    }

    public function testCanCountContents()
    {
        $result = ESString::wrap("Hello!")->count()->unwrap();
        $this->assertEquals(6, $result);

        $result = ESString::wrap("Hello!")->enumerated()->count()->unwrap();
        $this->assertEquals(6, $result);
    }

    public function testMinMaxForString()
    {
        $result = ESString::wrap("Hello!");
        $this->assertEquals("H", $result->min()->unwrap());
        $this->assertEquals("!", $result->max()->unwrap());
    }

    public function testCanDropFirstAndLast()
    {
        $result = ESString::wrap("Hello!")->dropFirst(2)->unwrap();
        $this->assertEquals("llo!", $result);

        $result = ESString::wrap("Hello!")->dropLast(4)->unwrap();
        $this->assertEquals("He", $result);
    }
}
