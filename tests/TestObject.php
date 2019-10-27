<?php

namespace Eightfold\Shoop\Tests;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Interfaces\Shooped;

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    CountableImp,
    WrapImp,
    HasImp,
    CompareImp
};

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\ESInt;
use Eightfold\Shoop\ESBool;
use Eightfold\Shoop\ESArray;

class TestObject implements \ArrayAccess
{
    use ShoopedImp, CountableImp, WrapImp, HasImp, CompareImp;

    public function __construct($args = null)
    {
        $this->value = $args;
    }

// - Type Juggling
    public function string()
    {
        $string = (string) $this->value;
        return Shoop::string($string);
    }

    public function array()
    {
        $array = (array) $this->value;
        return Shoop::array($array);
    }

    public function dictionary()
    {
        if (Type::is($this, ESDictionary::class)) {
            return Shoop::dictionary($this->unfold());
        }
        $array = (array) $this->value;
        return Shoop::array($array)->dictionary();
    }

    public function int(): ESInt
    {
        if (is_int($this->value)) {
            return Shoop::int($this->value);
        }
        $count = count($this->arrayUnfolded());
        return Shoop::int($count);
    }

// - PHP single-method interfaces
// - Manipulate
    public function toggle($preserveMembers = true)
    {
        return Shoop::array($this->unfold())->toggle($preserveMembers);
    }

    public function sort($caseSensitive = true)
    {
        return Shoop::array($this->unfold())->sort($caseSensitive);
    }

// - Search
    public function startsWith($needle): ESBool
    {
        $cheat = ESArray::fold($this->value);
        return $cheat->startsWith($needle);
    }

    public function endsWith($needle): ESBool
    {
        $cheat = ESArray::fold($this->value);
        return $cheat->endsWith($needle);
    }

// - Math language
    public function plus(...$args)
    {
        $cheat = ESArray::fold($this->value);
        $new = $cheat->plus(...$args);
        return static::fold($new->unfold());
    }

    public function minus(...$args)
    {
        $cheat = ESArray::fold($this->value);
        return $cheat->minus(...$args);
    }

    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        return TestObject::fold($this->value * $int);
    }
}
