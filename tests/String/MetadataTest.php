<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESString;

use Eightfold\Shoop\Tests\String\TestStrings;

class MetadataTest extends TestCase
{
    use TestStrings;

    public function testCanCountCharacters()
    {
        $expected = 9;
        $result = ESString::fromString($this->plainTextWithUnicode())->count();
        $this->assertEquals($expected, $result);
    }

//-> Comparison & metadata
    public function testCanCheckEquality()
    {
        $compare = $this->unicode();
        $result = ESString::fromString($compare)
            ->isSameAs($compare);
        $this->assertTrue($result);
    }

    public function testCanCheckEqualityFails()
    {
        $compare = 'H';
        $result = ESString::fromString($this->unicode())
            ->isSameAs($compare);
        $this->assertFalse($result);
    }

    public function testCanCheckForPrefix()
    {
        $compare = $this->unicode();
        $result = ESString::fromString($compare)
            ->startsWith('😀😇🌍');
        $this->assertTrue($result);
    }

    public function testCanCheckForPrefixFails()
    {
        $compare = $this->unicode();
        $result = ESString::fromString($compare)
            ->startsWith('H');
        $this->assertFalse($result);
    }

    public function testCanCheckForPrefix2()
    {
        $compare = $this->unicode();
        $result = ESString::fromString($compare)
            ->hasPrefix('😀😇🌍');
        $this->assertTrue($result);
    }

    public function testCanCheckForSuffix()
    {
        $compare = $this->unicode();
        $result = ESString::fromString($compare)
            ->hasSuffix('🌍😍😌');
        $this->assertTrue($result);
    }
}
