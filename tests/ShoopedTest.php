<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Tests\TestObject;

class ShoopedTest extends TestCase
{
    public function testCanInitialize()
    {
        $result = TestObject::fold(12);
        $this->assertNotNull($result);
        $this->assertEquals(12, $result->unfold());
    }

    public function testCanTypeJuggle()
    {
        $base = TestObject::fold(3);

        $this->assertEquals("3", $base->string());
        $this->assertEquals([3], $base->array()->unfold());
        $this->assertEquals([], $base->dictionary()->unfold());
        $this->assertEquals(3, $base->object()->unfold()->scalar);
        $this->assertEquals(3, $base->intUnfolded());
        $this->assertTrue($base->boolUnfolded());
    }

    public function testPhpInterfaces()
    {
        $result = TestObject::fold([1, 2, 3, 4])->countUnfolded();
        $this->assertEquals(4, $result);

        $result = TestObject::fold("Hello");
        $this->assertEquals("Hello", $result);
    }

    public function testCanRearrangeThings()
    {
        $initial = [1, 2, 3];
        $base = TestObject::fold($initial);
        $result = $base->toggleUnfolded();
        $this->assertEquals([3, 2, 1], $result);

        $result = $base->toggle()->sortUnfolded();
        $this->assertEquals($initial, $result);
    }
}
