<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    ESTypeMap,
    ESString
};

class TypeMapTest extends TestCase
{
    public function testCanInitialize()
    {
        $result = ESTypeMap::fromValue("string");
        $this->assertNotNull($result);
        $this->assertEquals(ESString::class, $result->className()->unwrap());

        $result = ESTypeMap::fromClassName(ESString::class);
        $this->assertNotNull($result);
        $this->assertEquals(ESString::class, $result->className()->unwrap());

        $result = ESTypeMap::fromValue(false);
        $this->assertNotNull($result);
        $this->assertEquals("boolean", $result->phpTypeName()->unwrap());
    }
}
