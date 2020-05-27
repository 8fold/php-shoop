<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Helpers\PhpTypeHelpers;

class PhpTypeHelpersTest extends TestCase
{
    public function testStartsWith()
    {
        $string = "Hello";
        $actual = PhpTypeHelpers::startsWith($string, "He");
        $this->assertTrue($actual);

        $string = "setSomething";
        $actual = PhpTypeHelpers::startsWithSet($string);
        $this->assertTrue($actual);
    }

    public function testEndsWith()
    {
        $string = "Hello";
        $actual = PhpTypeHelpers::endsWith($string, "lo");
        $this->assertTrue($actual);

        $string = "somethingUnfolded";
        $actual = PhpTypeHelpers::endsWithUnfolded($string);
        $this->assertTrue($actual);
    }
}
