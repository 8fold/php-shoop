<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\{
    Interfaces\Foldable,
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
    public function shuffle(): Foldable
    {
        $array = $this->arrayUnfolded();
        shuffle($array);
        if (Type::is($this, ESArray::class)) {
            return Shoop::array($array);

        } elseif (Type::is($this, ESString::class)) {
            $string = implode("", $array);
            return Shoop::string($string);

        }
    }
}
