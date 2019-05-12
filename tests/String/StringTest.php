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
        $result = ESString::fromString($this->unicode())
            ->dropFirst(2);
        $this->assertEquals($expected, $result);
    }

    public function testCanDropLastCount()
    {
        $expected = '😀😇🌍';
        $result = ESString::fromString($this->unicode())
            ->dropLast(2);
        $this->assertEquals($expected, $result);
    }

    public function testCanPopLasts()
    {
        $expected = '😀😇🌍😍';
        $result = ESString::fromString($this->unicode())
            ->popLast();
        $this->assertEquals($expected, $result);
    }

    public function testCanGetLowercasedString()
    {
        $expected = 'hello, 🌍!';
        $string = ESString::fromString($this->plainTextWithUnicode());
        $result = $string->lowercased();
        $this->assertEquals($expected, $result);
        $this->assertEquals($this->plainTextWithUnicode(), $string->string());
    }

    public function testCanGetUppercasedString()
    {
        $expected = 'HELLO, 🌍!';
        $string = ESString::fromString($this->plainTextWithUnicode());
        $result = $string->uppercased();
        $this->assertEquals($expected, $result);
        $this->assertEquals($this->plainTextWithUnicode(), $string->string());
    }

    public function testCanRetrieveFirstCharacterPlaintext()
    {
        $expected = 'H';
        $result = ESString::fromString($this->plainText())->first();
        $this->assertEquals($expected, $result);
    }

    public function testCanRetrieveFirstCharacterUnicode()
    {
        $expected = '😀';
        $result = ESString::fromString($this->unicode())->first();
        $this->assertEquals($expected, $result);
    }

    public function testCanRetrieveLastCharacterPlaintext()
    {
        $expected = '!';
        $result = ESString::fromString($this->plainText())->last();
        $this->assertEquals($expected, $result);
    }

    public function testCanRetrieveLastCharacterUnicode()
    {
        $expected = '😌';
        $result = ESString::fromString($this->unicode())->last();
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
        $result = ESString::fromString($this->plainTextWithUnicode())->sorted();
        $this->assertEquals($expected, $result);
    }
}
