<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    ESBaseType
};

class BaseTypeTest extends TestCase
{
    public function testCanWrap()
    {
        $expected = "hello";
        $result = ESBaseType::fold($expected);
        $this->assertNotNull($result);

        $this->assertEquals($expected, $result->unfold());
    }
    // TODO: Make this work - exception being raised but not caught by PHPUnit
    // public function testWillThrowErrorWhenMethodNotFound()
    // {
    //     $this->expectException(\ErrorException::class);
    //     $base = ESBaseType::wrap("hello");
    //     $base->stupendous();
    // }

    public function testCanCheckEqualityUsingESBaseType()
    {
        $first = ESBaseType::fold("hello");
        $second = ESBaseType::fold("world");

        $this->assertEquals("hello", $first->unfold());
        $this->assertEquals("world", $second->unfold());

        $this->assertFalse($first->isSame($second)->unfold());
        $this->assertTrue($first->isNot($second)->unfold());

        $second = "world";

        $this->assertFalse($first->isSameUnfolded($second));
        $this->assertTrue($first->isNotUnfolded($second));
    }

    public function testCanTestForEmpty()
    {
        $result = ESBaseType::fold("")->isEmpty()->unfold();
        $this->assertTrue($result);

        $result = ESBaseType::fold("Hello")->isEmpty()->unfold();
        $this->assertFalse($result);
    }

    public function testCanUserGet()
    {
        $result = ESBaseType::fold("")->isEmptyUnfolded();
        $this->assertTrue($result);
    }
}
