<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\ESInt;

class ShoopTest extends TestCase
{
    public function testCanGetTypeForValues()
    {
        $this->assertEquals("int", Type::for(1));
        $this->assertEquals(ESInt::class, Type::shoopFor(1));
        $this->assertEquals(ESInt::class, get_class(Shoop::int(1)));

        $this->assertTrue(Type::isPhp(1));
    }
}
