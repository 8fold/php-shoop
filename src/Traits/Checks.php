<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\{
    Shoop,
    ESBool
};

use Eightfold\Interfaces\Shooped;

trait Checks
{
    public function isEmpty(): ESBool
    {
        $result = empty($this->unfold());
        return Shoop::bool($result);
    }

    public function isArray()
    {
        return Shoop::valueIsArray($this->unfold());
    }

    public function isNotArray()
    {
        return Shoop::valueIsNotArray($this->unfold());
    }

    public function isSame($compare): ESBool
    {
        if (Shoop::valueIsNotShooped($compare)) {
            $compare = Shoop::instanceFromValue($compare);

        }
        return Shoop::bool($this->unfold() === $compare->unfold());
    }

    public function isNot($compare): ESBool
    {
        return $this->isSame($compare)->toggle();
    }
}
