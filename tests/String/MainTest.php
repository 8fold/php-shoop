<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESString;

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
}
