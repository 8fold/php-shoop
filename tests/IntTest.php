<?php
namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\ESInt;

class IntTest extends TestCase
{
    public function testCanInitialize()
    {
        $expected = 5;

        $actual = (new ESInt($expected))->unfold();
        $this->assertEquals($expected, $actual);

        $actual = (new ESInt("5"))->unfold();
        $this->assertEquals($expected, $actual);

        $actual = Shoop::int($expected)->unfold();
        $this->assertEquals($expected, $actual);

        $actual = Shoop::int("5")->unfold();
        $this->assertEquals($expected, $actual);

        $actual = Shoop::int("05")->unfold();
        $this->assertEquals($expected, $actual);
    }
}
