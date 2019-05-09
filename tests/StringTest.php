<?php

namespace Eightfold\String\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\String\Str;

use Eightfold\String\Tests\TestStrings;

class StringTest extends TestCase
{
    use TestStrings;

    public function testCanDropFirstCount()
    {
        $expected = '🌍😍😌';
        $result = Str::fromString($this->unicode())
            ->dropFirst(2);
        $this->assertEquals($expected, $result);
    }

    public function testCanDropLastCount()
    {
        $expected = '😀😇🌍';
        $result = Str::fromString($this->unicode())
            ->dropLast(2);
        $this->assertEquals($expected, $result);
    }

    public function testCanPopLasts()
    {
        $expected = '😀😇🌍😍';
        $result = Str::fromString($this->unicode())
            ->popLast();
        $this->assertEquals($expected, $result);
    }

    public function testCanGetLowercasedString()
    {
        $expected = 'hello, 🌍!';
        $string = Str::fromString($this->plainTextWithUnicode());
        $result = $string->lowercased();
        $this->assertEquals($expected, $result);
        $this->assertEquals($this->plainTextWithUnicode(), $string->string());
    }

    public function testCanGetUppercasedString()
    {
        $expected = 'HELLO, 🌍!';
        $string = Str::fromString($this->plainTextWithUnicode());
        $result = $string->uppercased();
        $this->assertEquals($expected, $result);
        $this->assertEquals($this->plainTextWithUnicode(), $string->string());
    }

    public function testCanRetrieveFirstCharacterPlaintext()
    {
        $expected = 'H';
        $result = Str::fromString($this->plainText())->first();
        $this->assertEquals($expected, $result);
    }

    public function testCanRetrieveFirstCharacterUnicode()
    {
        $expected = '😀';
        $result = Str::fromString($this->unicode())->first();
        $this->assertEquals($expected, $result);
    }

    public function testCanRetrieveLastCharacterPlaintext()
    {
        $expected = '!';
        $result = Str::fromString($this->plainText())->last();
        $this->assertEquals($expected, $result);
    }

    public function testCanRetrieveLastCharacterUnicode()
    {
        $expected = '😌';
        $result = Str::fromString($this->unicode())->last();
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
        $result = Str::fromString($this->plainTextWithUnicode())->sorted();
        $this->assertEquals($expected, $result);
    }
}
