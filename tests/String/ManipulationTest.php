<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Str;

use Eightfold\Shoop\Tests\String\TestStrings;

class ManipulationTest extends TestCase
{
    use TestStrings;

    public function testCanAppendStringWithString()
    {
        $expected = $this->plainTextWithUnicode();
        $result = Str::fromString('Hello')
            ->append(', 🌍!')
            ->string();
        $this->assertEquals($expected, $result);
    }

    public function testCanAppendStringFromFile()
    {
        $expected = 'Hello, 🌍!Hello, 🌍!';

        $dir = __DIR__ .'/test.txt';
        $result = Str::fromString($this->plainTextWithUnicode())->appendFromFile($dir)->string();
        $this->assertEquals($expected, $result);
    }

    public function testCanAppendStringFromFileTwice()
    {
        $expected = 'Hello, 🌍!Hello, 🌍!';

        $dir = __DIR__ .'/test.txt';
        $result = Str::empty()
            ->appendFromFile($dir, 2)
            ->string();
        $this->assertEquals($expected, $result);
    }

    public function testCanInsertCharacters()
    {
        $expected = $this->plainTextWithUnicode();
        $string = Str::fromString('Hello 🌍!');
        $this->assertEquals('Hello 🌍!', $string->string());

        $string->insert(',', 5);
        $this->assertEquals($expected, $string->string());
    }

    public function testCanInsertMBChars()
    {
        $expected = '🌍,🌍,🌍,🌍,🌍';
        $string = Str::fromString('🌍,🌍,🌍🌍,🌍');
        $this->assertEquals('🌍,🌍,🌍🌍,🌍', $string->string());

        $string->insert(',', 5);
        $this->assertEquals($expected, $string->string());
    }

    public function testCanInsertFromFile()
    {
        $expected = 'AHello, 🌍!Z';

        $dir = __DIR__ .'/test.txt';
        $result = Str::fromString('AZ')
            ->insertFromFile($dir, 1)
            ->string();
        $this->assertEquals($expected, $result);
    }

    public function testCanReplaceSubrange()
    {
        $expected = 'Hello, world!';
        $result = Str::fromString($this->plainTextWithUnicode())
            ->replaceSubrange('world', 7, 1)
            ->string();
        $this->assertEquals($expected, $result);
    }

    public function testCanReplaceSubrangeReversed()
    {
        $expected = $this->plainTextWithUnicode();
        $result = Str::fromString('Hello, world!')
            ->replaceSubrange('🌍', 7, 5)
            ->string();
        $this->assertEquals($expected, $result);
    }

    public function testCanRemoveCharAtIndex()
    {
        $expected = ',';
        $string = Str::fromString($this->plainText());
        $char = $string->remove(6); // H
        $str = $string->string(); // ello, World!

        $this->assertEquals($expected, $char);
        $this->assertEquals('Hello World!', $str);
    }

    public function testCanRemoveCharFirst()
    {
        $expected = 'H';
        $string = Str::fromString($this->plainText());
        $char = $string->removeFirst(); // H
        $str = $string->string(); // ello, World!

        $this->assertEquals($expected, $char);
        $this->assertEquals('ello, World!', $str);
    }

    public function testCanRemoveCharLast()
    {
        $expected = '!';
        $string = Str::fromString($this->plainText());
        $char = $string->removeLast(); // H
        $str = $string->string(); // ello, World!

        $this->assertEquals($expected, $char);
        $this->assertEquals('Hello, World', $str);
    }

    public function testCanRemoveSubrange()
    {
        $expected = '🌍';
        $result = Str::fromString($this->unicode())
            ->removeSubrange(1, 2)
            ->removeSubrange(2, 2)
            ->string();
        $this->assertEquals($expected, $result);
    }
}
