<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\ESInt;

class ShoopTest extends TestCase
{
    public function testCanGetTypeForValues()
    {
        $this->assertEquals("int", Shoop::phpTypeForValue(1));
        $this->assertEquals(ESInt::class, Shoop::shoopTypeForValue(1));
        $this->assertEquals(ESInt::class, get_class(Shoop::int(1)));

        $this->assertTrue(Shoop::valueIsPhpType(1));
    }
}
