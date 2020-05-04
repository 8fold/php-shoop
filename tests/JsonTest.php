<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    Helpers\Type
};

class JsonTest extends TestCase
{
    public function testJsonSerialize()
    {
        $json = Shoop::json('{"member":"test"}');
        $expected = new \stdClass();
        $expected->member = "test";
        $actual = json_decode($json);
        $this->assertEquals($expected, $actual);
    }
}
