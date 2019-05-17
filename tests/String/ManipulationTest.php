<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESString;

use Eightfold\Shoop\Tests\String\TestStrings;

class ManipulationTest extends TestCase
{
    use TestStrings;

    public function testCanAppendStringWithString()
    {
        $expected = '🌍,🌍,🌍,🌍,🌍,';
        $result = ESString::wrap('🌍,')
            ->multipliedBy(5)
            ->unwrap();
        $this->assertEquals($expected, $result);
    }

    public function testCanInsertCharacters()
    {
        $expected = $this->plainTextWithUnicode();
        $string = ESString::wrap('Hello 🌍!');
        $this->assertEquals('Hello 🌍!', $string->unwrap());

        $string->insert(',', 5);
        $this->assertEquals($expected, $string->unwrap());
    }

    public function testCanInsertMBChars()
    {
        $expected = '🌍,🌍,🌍,🌍,🌍';
        $string = ESString::wrap('🌍,🌍,🌍🌍,🌍');
        $this->assertEquals('🌍,🌍,🌍🌍,🌍', $string->unwrap());

        $string->insert(',', 5);
        $this->assertEquals($expected, $string->unwrap());
    }

    public function testCanReplaceSubrange()
    {
        $expected = 'Hello, world!';
        $result = ESString::wrap($this->plainTextWithUnicode())
            ->replaceSubrange('world', 7, 1)
            ->unwrap();
        $this->assertEquals($expected, $result);
    }

    public function testCanReplaceSubrangeReversed()
    {
        $expected = $this->plainTextWithUnicode();
        $result = ESString::wrap('Hello, world!')
            ->replaceSubrange('🌍', 7, 5)
            ->unwrap();
        $this->assertEquals($expected, $result);
    }

    public function testCanRemoveCharAtIndex()
    {
        $expected = ',';
        $string = ESString::wrap($this->plainText());
        $char = $string->remove(6); // H
        $str = $string->unwrap(); // ello, World!

        $this->assertEquals($expected, $char);
        $this->assertEquals('Hello World!', $str);
    }

    public function testCanRemoveCharFirst()
    {
        $expected = 'H';
        $string = ESString::wrap($this->plainText());
        $char = $string->removeFirst(); // H
        $str = $string->unwrap(); // ello, World!

        $this->assertEquals($expected, $char);
        $this->assertEquals('ello, World!', $str);
    }

    public function testCanRemoveCharLast()
    {
        $expected = '!';
        $string = ESString::wrap($this->plainText());
        $char = $string->removeLast(); // H
        $str = $string->unwrap(); // ello, World!

        $this->assertEquals($expected, $char);
        $this->assertEquals('Hello, World', $str);
    }

    public function testCanRemoveSubrange()
    {
        $expected = '🌍';
        $result = ESString::wrap($this->unicode())
            ->removeSubrange(1, 2)
            ->removeSubrange(2, 2)
            ->unwrap();
        $this->assertEquals($expected, $result);
    }
}
