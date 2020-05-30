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
    public function isIn($haystack, \Closure $closure = null)
    {
        $needle = $this->value;
        $h = Type::sanitizeType($haystack, ESArray::class)->unfold();
        $bool = in_array($needle, $h);
        if (Type::is($this, ESString::class, ESJson::class)) {
            $h = Type::sanitizeType($haystack, ESString::class)->unfold();
            $bool = strpos($h, $needle) !== false;

        }
        return $this->condition($bool, $closure);
    }

    public function isNotIn($haystack, \Closure $closure = null)
    {
        $bool = $this->isIn($haystack)->toggle();
        return $this->condition($bool, $closure);
    }
}
