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
 * @see Eightfold\Shoop\Helpers\Type::is
 *
 * @return Eightfold\Shoop\ESBoolean After toggling the return of `is()`.
 */
class IsNotTest extends TestCase
{
    public function testESArray()
    {
        $base = ["hello", "world"];
        $actual = ESArray::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESBoolean()
    {
        $base = true;
        $actual = ESBoolean::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESDictionary()
    {
        $base = ["member" => "value"];
        $actual = ESDictionary::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESInteger()
    {
        $base = 10;
        $actual = ESInteger::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESJson()
    {
        $base = '{"test":"test"}';
        $actual = ESJson::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESTuple()
    {
        $base = new \stdClass();
        $base->test = "test";
        $actual = ESTuple::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }

    public function testESString()
    {
        $base = "alphabet soup";
        $actual = ESString::fold($base)->isNot($base);
        $this->assertFalse($actual->unfold());
    }
}
