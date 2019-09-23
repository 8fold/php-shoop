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
    public function testCanInitializeWithString()
    {
        $expected = $this->plainTextWithUnicode();
        $result = ESString::fold($this->plainTextWithUnicode());
        $this->assertEquals($expected, $result->unfold());
    }

    public function testCanCreateBasicDataTypes()
    {
        $result = Shoop::int(1)->unfold();
        $this->assertEquals(1, $result);

        $result = Shoop::string("Hello!")->unfold();
        $this->assertEquals("Hello!", $result);

        $result = Shoop::array([1, 2, 3, 4, 5])->unfold();
        $this->assertEquals([1, 2, 3, 4, 5], $result);
    }
}
