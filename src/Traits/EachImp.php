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

trait EachImp
{
    public function each(\Closure $closure): ESArray
    {
        if (Type::is($this, ESArray::class, ESDictionary::class)) {
            $items = $this->value();
            $array = array_map($closure, array_values($items), array_keys($items));
            return Shoop::this($array);

        } elseif (Type::is($this, ESInt::class, ESString::class)) {
            return $this->array()->each($closure);

        } elseif (Type::is($this, ESJson::class, ESObject::class)) {
            return $this->dictionary()->each($closure);

        }
    }
}
