<?php

namespace Eightfold\Shoop\Traits;

use \Closure;

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
    // TODO: is there a way to return a dictionary??
    public function each(Closure $closure): ESArray
    {
        if (Type::is($this, ESArray::class, ESDictionary::class)) {
            $items = $this->main();
            $break = false;
            $array = [];
            foreach ($items as $member => $value) {
                $array[] = $closure($value, $member, $break);
                if ($break) {
                    break;
                }
            }
            return Shoop::this($array);

        } elseif (Type::is($this, ESInt::class, ESString::class)) {
            return $this->array()->each($closure);

        } elseif (Type::is($this, ESJson::class, ESObject::class)) {
            return $this->dictionary()->each($closure);

        }
    }
}
