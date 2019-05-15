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
        $result = ESBaseType::wrap($expected);
        $this->assertNotNull($result);

        $this->assertEquals($expected, $result->unwrap());
    }

    public function testCanCheckEquality()
    {
        $first = ESBaseType::wrap("hello");
        $second = ESBaseType::wrap("world");

        $this->assertFalse($first->isSameAs($second)->unwrap());
        $this->assertTrue($first->isDifferentThan($second)->unwrap());
    }

    public function testCanTestForEmpty()
    {
        $result = ESBaseType::wrap("")->isEmpty()->unwrap();
        $this->assertTrue($result);

        $result = ESBaseType::wrap("Hello")->isEmpty()->unwrap();
        $this->assertFalse($result);
    }
}
