<?php

namespace Eightfold\String\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\String\Str;

use Eightfold\String\Tests\TestStrings;

class MetadataTest extends TestCase
{
    use TestStrings;

    public function testCanCountCharacters()
    {
        $expected = 9;
        $result = Str::fromString($this->plainTextWithUnicode())->count();
        $this->assertEquals($expected, $result);
    }

//-> Comparison & metadata
    public function testCanCheckEquality()
    {
        $compare = $this->unicode();
        $result = Str::fromString($compare)
            ->isSameAs($compare);
        $this->assertTrue($result);
    }

    public function testCanCheckEqualityFails()
    {
        $compare = 'H';
        $result = Str::fromString($this->unicode())
            ->isSameAs($compare);
        $this->assertFalse($result);
    }

    public function testCanCheckForPrefix()
    {
        $compare = $this->unicode();
        $result = Str::fromString($compare)
            ->startsWith('😀😇🌍');
        $this->assertTrue($result);
    }

    public function testCanCheckForPrefixFails()
    {
        $compare = $this->unicode();
        $result = Str::fromString($compare)
            ->startsWith('H');
        $this->assertFalse($result);
    }

    public function testCanCheckForPrefix2()
    {
        $compare = $this->unicode();
        $result = Str::fromString($compare)
            ->hasPrefix('😀😇🌍');
        $this->assertTrue($result);
    }

    public function testCanCheckForSuffix()
    {
        $compare = $this->unicode();
        $result = Str::fromString($compare)
            ->hasSuffix('🌍😍😌');
        $this->assertTrue($result);
    }
}
