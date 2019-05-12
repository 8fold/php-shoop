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
        $result = $result->toggle();
        $this->assertFalse($result->bool());

        $compare = ESBool::init(false);
        $this->assertTrue($result->isSameAs($compare)->bool());

        $compare = $compare->toggle();
        $this->assertTrue($result->isNotSameAs($compare)->bool());

        $this->assertFalse($compare->not()->bool());

        $compare = $compare->toggle();
        $this->assertFalse($result->or($compare)->bool());

        $compare = $compare->toggle();
        $this->assertTrue($result->or($compare)->bool());

        $result = $result->toggle();
        $this->assertTrue($result->and($compare)->bool());

        $compare = $compare->toggle();
        $this->assertFalse($result->and($compare)->bool());
    }
}
