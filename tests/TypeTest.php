<?php

namespace Eightfold\Shoop\Tests;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\ESBool;

class TypeTest extends TestCase
{
    public function testCanGetTypeFromType()
    {
        $shoop = ESBool::class;
        $result = Type::phpToShoop("bool");
        $this->assertEquals($shoop, $result);

        $php = "bool";
        $result = Type::shoopToPhp($shoop);
        $this->assertEquals($php, $result);

        $result = Type::for(Shoop::bool(true));
        $this->assertEquals($shoop, $result);

        $result = Type::for(true);
        $this->assertEquals($php, $result);

        $result = Type::isShooped(ESBool::fold(true));
        $this->assertTrue($result);

        $result = Type::isPhp($php);
        $this->assertTrue($result);
    }
}
