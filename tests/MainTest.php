<?php

namespace Eightfold\String\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\String\Str;

use Eightfold\String\Tests\TestStrings;

class MainTest extends TestCase
{
    use TestStrings;

//-> Initializers
    public function testCanInitializeEmptyString()
    {
        $result = Str::empty();

        $this->assertNotNull($result);
        $this->assertTrue($result->isEmpty());
    }

    public function testCanInitializeWithString()
    {
        $expected = $this->plainTextWithUnicode();
        $result = Str::fromString($this->plainTextWithUnicode())->string();
        $this->assertEquals($expected, $result);
    }

    public function testCanInitializeByRepeatingString()
    {
        $expected = '🌍🌍🌍';
        $result = Str::byRepeating('🌍', 3)->string();
        $this->assertEquals($expected, $result);
    }

    public function testCanInitializeFromFile()
    {
        $expected = $this->plainTextWithUnicode();

        $dir = __DIR__ .'/test.txt';
        $result = Str::fromFile($dir)->string();
        $this->assertEquals($expected, $result);
    }
}
