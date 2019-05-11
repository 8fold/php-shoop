<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESBool;

class BoolTest extends TestCase
{
    public function testCanInitialize()
    {
        $result = ESBool::init();
        $this->assertNotNull($result);
        $this->assertTrue($result->bool());
        $this->assertEquals("true", $result->description());
        $this->assertFalse($result->toggle()->bool());

        $compare = ESBool::init(false);
        $this->assertTrue($result->isSameAs($compare)->bool());

        $compare->toggle();
        $this->assertTrue($result->isNotSameAs($compare)->bool());

        $this->assertFalse($compare->not()->bool());

        $this->assertFalse($result->or($compare)->bool());

        $compare->toggle();
        $this->assertTrue($result->or($compare)->bool());

        $result->toggle();
        $this->assertTrue($result->and($compare)->bool());

        $compare->toggle();
        $this->assertFalse($result->and($compare)->bool());
    }
}
