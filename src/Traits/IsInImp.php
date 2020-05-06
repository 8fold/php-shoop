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

trait IsInImp
{
    public function isIn($haystack): ESBool
    {
        $needle = $this->value;
        $h = Type::sanitizeType($haystack, ESArray::class)->unfold();
        $bool = in_array($needle, $h);
        if (Type::is($this, ESString::class)) {
            $h = Type::sanitizeType($haystack, ESString::class)->unfold();
            $bool = strpos($h, $needle) !== false;

        }
        return Shoop::bool($bool);
    }
}
