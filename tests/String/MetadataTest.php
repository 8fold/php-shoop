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
        $result = ESString::wrap($this->plainTextWithUnicode())->count()->unwrap();
        $this->assertEquals($expected, $result);
    }

//-> Comparison & metadata
    public function testCanCheckEquality()
    {
        $compare = $this->unicode();
        $result = ESString::wrap($compare)
            ->isSameAs(ESString::wrap($compare));
        $this->assertTrue($result->unwrap());
    }

    public function testCanCheckEqualityFails()
    {
        $compare = ESString::wrap('H');
        $result = ESString::wrap($this->unicode())
            ->isSameAs($compare);
        $this->assertFalse($result->unwrap());
    }

    public function testCanCheckForPrefix()
    {
        $compare = $this->unicode();
        $result = ESString::wrap($compare)
            ->startsWith('😀😇🌍');
        $this->assertTrue($result->unwrap());
    }
}
