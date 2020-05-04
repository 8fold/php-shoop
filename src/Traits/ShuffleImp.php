<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    ESBool,
    ESInt,
    ESString,
    ESObject,
    ESJson,
    ESDictionary
};

trait ShuffleImp
{
    public function shuffle()
    {
        if (Type::is($this, ESArray::class)) {
            $array = $this->value;
            shuffle($array);
            return Shoop::array($array);

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->value;
            $array = $this->stringToIndexedArray($string);
            shuffle($array);
            $string = implode("", $array);
            return Shoop::string($string);

        }
    }
}
