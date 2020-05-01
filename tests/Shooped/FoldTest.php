<?php

namespace Eightfold\Shoop\Tests\Shooped;

use PHPUnit\Framework\TestCase;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};
/**
 * The `fold()` static method acts as an alias for the constructor of each type.
 *
 * PHP types get "folded" into Shoop, then "unfolded" back to PHP.
 *
 * @declared Eightfold\Shoop\Interfaces\Shooped
 *
 * @defined Eightfold\Shoop\Traits\ShoopedImp
 */
class FoldTest extends TestCase
{
    /**
     * @return ESArray Requires a PHP array, even if empty. (Note: *Associative* arrays will be converted to *indexed*.)
     */
    public function testESArray()
    {
        $actual = new ESArray(['testing']);
        $this->assertTrue(is_a($actual, ESArray::class));

        $actual = ESArray::fold(['testing']);
        $this->assertTrue(is_a($actual, ESArray::class));
    }

    /**
     * @return ESBool Require initial PHP boolean value.
     */
    public function testESBool()
    {
        $actual = new ESBool(true);
        $this->assertTrue(is_a($actual, ESBool::class));

        $actual = ESBool::fold(true);
        $this->assertTrue(is_a($actual, ESBool::class));
    }

    /**
     * @return ESDictionary Requires a PHP associative array, even if empty.
     */
    public function testESDictionary()
    {
        $actual = new ESDictionary([]);
        $this->assertTrue(is_a($actual, ESDictionary::class));

        $actual = ESDictionary::fold([]);
        $this->assertTrue(is_a($actual, ESDictionary::class));
    }

    /**
     * @return ESInt Requires initial PHP integer.
     */
    public function testESInt()
    {
        $actual = new ESInt(1);
        $this->assertTrue(is_a($actual, ESInt::class));

        $actual = ESInt::fold(1);
        $this->assertTrue(is_a($actual, ESInt::class));
    }

    /**
     * @return ESJson Requires stringable parameter that results in valid JSON.
     */
    public function testESJson()
    {
        $actual = new ESJson('{"test":"test"}');
        $this->assertTrue(is_a($actual, ESJson::class));

        $actual = ESJson::fold('{"test":"test"}');
        $this->assertTrue(is_a($actual, ESJson::class));
    }

    /**
     * @return ESObject Requires instance of `stdClass` or `ESObject`, even if empty.
     */
    public function testESObject()
    {
        $actual = new ESObject(new \stdClass());
        $this->assertTrue(is_a($actual, ESObject::class));

        $actual = ESObject::fold(new \stdClass());
        $this->assertTrue(is_a($actual, ESObject::class));
    }

    /**
     * @return ESString Requires initial PHP string, even if empty.
     */
    public function testESString()
    {
        $actual = new ESString("");
        $this->assertTrue(is_a($actual, ESString::class));

        $actual = ESString::fold("");
        $this->assertTrue(is_a($actual, ESString::class));
    }
}
