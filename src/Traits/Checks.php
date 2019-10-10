<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\{
    Shoop,
    ESBool
};

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Helpers\Type;

trait Checks
{
    public function isEmpty(): ESBool
    {
        $result = empty($this->unfold());
        return Shoop::bool($result);
    }

    public function isArray(): ESBool
    {
        return Type::isArray($this);
    }

    public function isNotArray(): ESBool
    {
        return Type::isNotArray($this);
    }

    public function isSame($compare): ESBool
    {
        if (Type::isNotShooped($compare)) {
            $compare = $this->sanitizeType($compare);

        }
        return Shoop::bool($this->unfold() === $compare->unfold());
    }

    public function isNot($compare): ESBool
    {
        return $this->isSame($compare)->toggle();
    }
}
