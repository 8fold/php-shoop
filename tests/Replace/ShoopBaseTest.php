<?php

namespace Eightfold\Shoop\Tests\Replace;

use Eightfold\Shoop\Tests\TestCase;

use Eightfold\Shoop\Tests\Replace\ESGenericType;

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\{ESString};

class ShoopBaseTest extends TestCase
{
    public function test_ESString_foldability()
    {
        $expected = "string";
        $actual = new ESString("string");
        $this->assertEqualsWithPerformance($expected, $actual->unfold());

        $this->start = hrtime(true);
        $actual = ESString::fold("string");
        $this->assertEqualsWithPerformance($expected, $actual->unfold());
    }

    public function test_ESGenericType_foldability()
    {
        $expected = "string";
        $actual = new ESGenericType("string");
        $this->assertEqualsWithPerformance($expected, $actual->unfold());

        $this->start = hrtime(true);
        $actual = ESGenericType::fold("string")->unfold();
        $this->assertEqualsWithPerformance($expected, $actual);
    }

    public function test_ESGenericType_types()
    {
        $actual = new ESGenericType;
        $this->assertTrue(is_a($actual, Shooped::class));
        $this->assertTrue(is_a($actual, Foldable::class));
        // Compare
        // PhpInterfaces
        // PhpMagicMethods
    }
}
