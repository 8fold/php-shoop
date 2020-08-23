<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESDictionary,
    ESInteger,
    ESJson,
    ESTuple,
    ESString
};

/**
 * @see Eightfold\Helpers\Type::isEmpty
 */
class IsEmptyTest extends TestCase
{
    public function ESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->isEmpty();
        $this->assertFalse($actual->unfold());

        $actual = ESArray::fold($base)->isEmpty(function($result, $value) {
            if (! $result->unfold()) {
                return Shoop::string($value->last);
            }
        });
        $this->assertEquals("world", $actual->unfold());

        $base = [];
        $actual = ESArray::fold($base)->isEmpty();
        $this->assertTrue($actual->unfold());

        $actual = ESArray::fold($base)->isEmpty(function($result, $value) {
            if ($result) {
                return Shoop::string("");
            }
        });
        $this->assertEquals("", $actual->unfold());
    }

    public function ESBoolean()
    {
        $base = true;
        $actual = ESBoolean::fold($base)->isEmpty();
        $this->assertFalse($actual->unfold());

        $base = false;
        $actual = ESBoolean::fold($base)->isEmpty();
        $this->assertTrue($actual->unfold());
    }

    public function ESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->isEmpty();
        $this->assertFalse($actual->unfold());
    }

    public function ESInteger()
    {
        $base = 0;
        $actual = ESInteger::fold($base)->isEmpty();
        $this->assertTrue($actual->unfold());

        $base = 10;
        $actual = ESInteger::fold($base)->isEmpty();
        $this->assertFalse($actual->unfold());

        $base = -1;
        $actual = ESInteger::fold($base)->isEmpty();
        $this->assertFalse($actual->unfold());
    }

    /**
     * Uses `object()` then checks if the ESTuple `isEmpty()` (no members).
     */
    public function ESJson()
    {
        $base = '{}';
        $actual = ESJson::fold($base)->isEmpty();
        $this->assertTrue($actual->unfold());

        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->isEmpty();
        $this->assertFalse($actual->unfold());
    }

    /**
     * Uses `dictionary()` then checks if the ESDictionary `isEmpty()`
     */
    public function ESTuple()
    {
        $base = new \stdClass();
        $base->test = "test";
        $actual = ESTuple::fold($base)->isEmpty();
        $this->assertFalse($actual->unfold());
    }

    public function ESString()
    {
        $base = "alphabet soup";
        $actual = ESString::fold($base)->isEmpty();
        $this->assertFalse($actual->unfold());

        $base = "";
        $actual = ESString::fold($base)->isEmpty();
        $this->assertTrue($actual->unfold());
    }
}
