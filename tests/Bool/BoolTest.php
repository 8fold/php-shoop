<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\ESBool;

class BoolTest extends TestCase
{
    public function testCanInitialize()
    {
        $result = ESBool::wrap();
        $this->assertNotNull($result);
        $this->assertTrue($result->unwrap());
        $this->assertEquals("true", $result->description()->unwrap());
        $result = $result->toggle();
        $this->assertFalse($result->unwrap());

        $compare = ESBool::wrap(false);
        $this->assertTrue($result->isSameAs($compare)->unwrap());

        $compare = $compare->toggle();
        $this->assertTrue($result->isDifferentThan($compare)->unwrap());

        $this->assertFalse($compare->not()->unwrap());

        $compare = $compare->toggle();
        $this->assertFalse($result->or($compare)->unwrap());

        $compare = $compare->toggle();
        $this->assertTrue($result->or($compare)->unwrap());

        $result = $result->toggle();
        $this->assertTrue($result->and($compare)->unwrap());

        $compare = $compare->toggle();
        $this->assertFalse($result->and($compare)->unwrap());
    }

    public function testEquatable()
    {
        $result = ESBool::wrap(true);
        $compare = ESBool::wrap(true);
        $this->assertTrue($result->isSameAs($compare)->unwrap());

        $compare = $compare->toggle();
        $this->assertFalse($result->isSameAs($compare)->unwrap());
        $this->assertTrue($result->isDifferentThan($compare)->unwrap());
    }
}
