<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    Helpers\Type
};

class ObjectTest extends TestCase
{
    public function testRename()
    {
        $object = new \stdClass();
        $object->member = "value";
        $object->member2 = "value2";

        $expected = new \stdClass();
        $expected->newMember = "value";
        $expected->newMember2 = "value2";

        $actual = Shoop::object($object)->renameMember("member", "newMember", "member2", "newMember2");
        $this->assertEquals($expected, $actual->unfold());
    }
}
