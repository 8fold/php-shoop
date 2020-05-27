<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\{
    Shoop,
    ESObject,
    ESString,
    Helpers\Type
};

class ObjectTest extends TestCase
{
    /**
     * @see https://github.com/8fold/php-shoop/issues/35
     */
    public function testObjectMember()
    {
        $object = new \stdClass();
        $object->object = new \stdClass();
        $object->string = "Hello!";

        $object = Shoop::this($object);
        $this->assertEquals(ESObject::class, get_class($object->object()));
        $this->assertEquals(ESString::class, get_class($object->string()));
    }
}
