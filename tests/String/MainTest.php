<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Shoop,
    ESString
};

use Eightfold\Shoop\Tests\String\TestStrings;

class MainTest extends TestCase
{
    use TestStrings;

//-> Initializers
    // public function testCanInitializeEmptyString()
    // {
    //     $result = ESString::wrap();

    //     $this->assertNotNull($result);
    //     $this->assertTrue($result->isEmpty()->unwrap());

    //     $result->random();
    // }

    public function testCanInitializeWithString()
    {
        $expected = $this->plainTextWithUnicode();
        $result = ESString::wrap($this->plainTextWithUnicode());
        $this->assertEquals($expected, $result->unwrap());
        $this->assertEquals($expected, $result->description()->unwrap());
    }

    public function testCanCreateBasicDataTypes()
    {
        $result = Shoop::int(1)->unwrap();
        $this->assertEquals(1, $result);

        $result = Shoop::string("Hello!")->unwrap();
        $this->assertEquals("Hello!", $result);

        $result = Shoop::array(1, 2, 3, 4, 5)->unwrap();
        $this->assertEquals([1, 2, 3, 4, 5], $result);

        $result = Shoop::range(1, 5)->enumerated()->unwrap();
        $this->assertEquals([1, 2, 3, 4, 5], $result);

        $result = Shoop::range(1, 5)->unwrap();
        $expected = Shoop::tuple(
            "min", Shoop::int(1),
            "max", Shoop::int(5),
            "closed", Shoop::bool(true)
        );
        $this->assertEquals($expected, $result);
        $result = Shoop::bool(false)->unwrap();
        $this->assertFalse($result);
    }
}
