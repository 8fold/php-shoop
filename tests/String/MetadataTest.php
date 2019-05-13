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
        $result = ESString::wrapString($this->plainTextWithUnicode())->count();
        $this->assertEquals($expected, $result);
    }

//-> Comparison & metadata
    public function testCanCheckEquality()
    {
        $compare = $this->unicode();
        $result = ESString::wrapString($compare)
            ->isSameAs(ESString::wrap($compare));
        $this->assertTrue($result->unwrap());
    }

    public function testCanCheckEqualityFails()
    {
        $compare = ESString::wrap('H');
        $result = ESString::wrapString($this->unicode())
            ->isSameAs($compare);
        $this->assertFalse($result->unwrap());
    }

    public function testCanCheckForPrefix()
    {
        $compare = $this->unicode();
        $result = ESString::wrapString($compare)
            ->startsWith('😀😇🌍');
        $this->assertTrue($result->unwrap());
    }

    public function testCanCheckForPrefixFails()
    {
        $compare = $this->unicode();
        $result = ESString::wrapString($compare)
            ->startsWith('H');
        $this->assertFalse($result->unwrap());
    }

    public function testCanCheckForPrefix2()
    {
        $compare = $this->unicode();
        $result = ESString::wrapString($compare)
            ->hasPrefix('😀😇🌍');
        $this->assertTrue($result->unwrap());
    }

    public function testCanCheckForSuffix()
    {
        $compare = $this->unicode();
        $result = ESString::wrapString($compare)
            ->hasSuffix('🌍😍😌');
        $this->assertTrue($result->unwrap());
    }
}
