<?php

namespace Eightfold\Shoop\FluentTypes\Traits;

use \Closure;



use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESInteger,
    ESString,
    ESTuple,
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

        } elseif (Type::is($this, ESInteger::class, ESString::class)) {
            return $this->array()->each($closure);

        } elseif (Type::is($this, ESJson::class, ESTuple::class)) {
            return $this->dictionary()->each($closure);

        }
    }
}
