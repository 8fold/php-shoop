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
        $this->assertEquals($expected, $result);
    }

    public function testCanDropLastCount()
    {
        $expected = '😀😇🌍';
        $result = ESString::wrap($this->unicode())
            ->dropLast(2);
        $this->assertEquals($expected, $result);
    }

    public function testCanPopLasts()
    {
        $expected = '😀😇🌍😍';
        $result = ESString::wrap($this->unicode())
            ->popLast();
        $this->assertEquals($expected, $result);
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
        $result = ESString::wrap($this->plainText())->first();
        $this->assertEquals($expected, $result);
    }

    public function testCanRetrieveFirstCharacterUnicode()
    {
        $expected = '😀';
        $result = ESString::wrap($this->unicode())->first();
        $this->assertEquals($expected, $result);
    }

    public function testCanRetrieveLastCharacterPlaintext()
    {
        $expected = '!';
        $result = ESString::wrap($this->plainText())->last();
        $this->assertEquals($expected, $result);
    }

    public function testCanRetrieveLastCharacterUnicode()
    {
        $expected = '😌';
        $result = ESString::wrap($this->unicode())->last();
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
        $result = ESString::wrap($this->plainTextWithUnicode())->sorted();
        $this->assertEquals($expected, $result);
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
}
