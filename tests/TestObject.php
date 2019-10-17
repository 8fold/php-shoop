<?php

namespace Eightfold\Shoop\Tests;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\ESInt;
use Eightfold\Shoop\ESBool;
use Eightfold\Shoop\ESArray;

class TestObject
{
    use ShoopedImp;

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
}
