<?php

namespace Eightfold\Shoop\FluentTypes\Traits;

use \Closure;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
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
    public function isIn($haystack, Closure $closure = null)
    {
        $needle = $this->main();
        $h = Type::sanitizeType($haystack, ESArray::class)->unfold();
        $bool = in_array($needle, $h);
        if (Type::is($this, ESString::class, ESJson::class)) {
            $h = Type::sanitizeType($haystack, ESString::class)->unfold();
            $bool = strpos($h, $needle) !== false;

        }
        return $this->condition($bool, $closure);
    }

    public function isNotIn($haystack, Closure $closure = null)
    {
        $bool = $this->isIn($haystack)->toggle();
        return $this->condition($bool, $closure);
    }
}
