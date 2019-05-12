<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESString;

use Eightfold\Shoop\Tests\String\TestStrings;

class MainTest extends TestCase
{
    use TestStrings;

//-> Initializers
    public function testCanInitializeEmptyString()
    {
        $result = ESString::wrapString();

        $this->assertNotNull($result);
        $this->assertTrue($result->isEmpty());
    }

    public function testCanInitializeWithString()
    {
        $expected = $this->plainTextWithUnicode();
        $result = ESString::wrapString($this->plainTextWithUnicode())->unwrap();
        $this->assertEquals($expected, $result);
    }

    public function testCanInitializeByRepeatingString()
    {
        $expected = '🌍🌍🌍';
        $result = ESString::wrapString('🌍', 3)->unwrap();
        $this->assertEquals($expected, $result);
    }
}
