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

    static public function valueIsNotArray($value)
    {
        return ! Shoop::valueIsArray($value);
    }

    public function isArray()
    {
        return is_array($this->unfold());
    }

    public function isNotArray()
    {
        return ! $this->isArray();
    }

    public function isSame($compare): ESBool
    {
        if (shoop::valueIsShooped($compare)) {
            return Shoop::bool($this->unfold() === $compare->unfold());

        }
        return Shoop::instanceFromValue($compare);
        // $map = Shoop::typeMap();
        // $type = Shoop::typeForValue($value);
        // if (! array_key_exists($type, $map) || $compare === null) {
        //     $compareString = var_dump($compare);
        //     trigger_error("{$compareString} is not a supported type in Shoop. Please submit an issue or PR through GitHub: 8fold/php-shoop");
        // }
        // $class = $map[$type];
        // return $class::fold($value);
    }

    public function isNot($compare): ESBool
    {
        return $this->isSame($compare)->toggle();
    }
}
