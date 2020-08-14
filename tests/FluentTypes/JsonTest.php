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
    /**
     * An instance of ESJson can be passed directly to the `json_decoded()` function in the PHP standard library.
     *
     * @return \stdClass
     */
    public function testJsonSerialize()
    {
        $json = Shoop::json('{"member":"test"}');
        $expected = new \stdClass();
        $expected->member = "test";
        $actual = json_decode($json);
        $this->assertEquals($expected, $actual);
    }
}
