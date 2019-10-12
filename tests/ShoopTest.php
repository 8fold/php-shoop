<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\ESInt;
use Eightfold\Shoop\ESObject;

class ShoopTest extends TestCase
{
    public function testCanGetTypeForValues()
    {
        $this->assertEquals("int", Type::for(1));
        $this->assertEquals(ESInt::class, Type::shoopFor(1));
        $this->assertEquals(ESInt::class, get_class(Shoop::int(1)));

        $this->assertTrue(Type::isPhp(1));
    }

    public function testCanUseObjectAsPhpString()
    {
        $expected = "Array([zero] => 0, [one] => 1)";
        $base = (object) ["zero" => 0, "one" => 1];
        $result = (string) ESObject::fold($base);
        $this->assertEquals($expected, $result);
    }
}
