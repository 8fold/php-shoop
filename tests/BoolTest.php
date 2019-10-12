<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESBool;

class BoolTest extends TestCase
{
    public function testCanInitialize()
    {
        $result = ESBool::fold(true);
        $this->assertNotNull($result);
        $this->assertTrue($result->unfold());
        $this->assertEquals("true", $result->description()->unfold());
        $result = $result->toggle();
        $this->assertFalse($result->unfold());

        $compare = ESBool::fold(false);
        $this->assertTrue($result->isSame($compare)->unfold());

        $compare = $compare->toggle();
        $this->assertTrue($result->isNot($compare)->unfold());

        $this->assertFalse($compare->not()->unfold());

        $compare = $compare->toggle();
        $this->assertFalse($result->or(false)->unfold());

        $compare = $compare->toggle();
        $this->assertTrue($result->or($compare)->unfold());

        $result = $result->toggle();
        $this->assertTrue($result->and($compare)->unfold());

        $compare = $compare->toggle();
        $this->assertFalse($result->and($compare)->unfold());
    }

    public function testEquatable()
    {
        $result = ESBool::fold(true);
        $compare = ESBool::fold(true);
        $this->assertTrue($result->isSame($compare)->unfold());

        $compare = $compare->toggle();
        $this->assertFalse($result->isSame($compare)->unfold());
        $this->assertTrue($result->isNotUnfolded($compare));
    }

    public function testCanBeUsedAsPhpString()
    {
        $expected = "1";
        $result = (string) ESBool::fold(true);
        $this->assertEquals($expected, $result);

        $expected = "";
        $result = (string) ESBool::fold(false);
        $this->assertEquals($expected, $result);
    }
}
