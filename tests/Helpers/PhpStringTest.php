<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Helpers\PhpString;

class PhpStringTest extends TestCase
{
    public function testStartsWith()
    {
        $string = "Hello";
        $actual = PhpString::startsWith($string, "He");
        $this->assertTrue($actual);

        $string = "setSomething";
        $actual = PhpString::startsWithSet($string);
        $this->assertTrue($actual);
    }

    public function testEndsWith()
    {
        $string = "Hello";
        $actual = PhpString::endsWith($string, "lo");
        $this->assertTrue($actual);

        $string = "somethingUnfolded";
        $actual = PhpString::endsWithUnfolded($string);
        $this->assertTrue($actual);
    }
}
