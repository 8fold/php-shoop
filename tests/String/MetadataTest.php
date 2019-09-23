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
        $result = ESString::fold($this->plainTextWithUnicode())->count()->unfold();
        $this->assertEquals($expected, $result);
    }

//-> Comparison & metadata
    public function testCanCheckEquality()
    {
        $compare = $this->unicode();
        $result = ESString::fold($compare)
            ->isSame(ESString::fold($compare));
        $this->assertTrue($result->unfold());
    }

    public function testCanCheckEqualityFails()
    {
        $compare = ESString::fold('H');
        $result = ESString::fold($this->unicode())
            ->isSame($compare);
        $this->assertFalse($result->unfold());
    }
}
