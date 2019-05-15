<?php

namespace Eightfold\Shoop;

use Illuminate\Support\Arr as IlluminateArray;

use Eightfold\Shoop\{
    ESBaseType,
    ESString,
    ESBool
};

use Eightfold\Shoop\Interfaces\{
    Wrappable,
    Equatable,
    Describable,
    Randomizable,
    Storeable,
    EquatableImp,
    RandomizableImp,
    StoreableImp
};

class ESArray extends ESBaseType implements
    Wrappable,
    Describable,
    Randomizable,
    Storeable
{
    use
        RandomizableImp,
        StoreableImp;

    // private $value = [];

    // static public function wrap(...$args): ESArray
    // {
    //     return new ESArray(IlluminateArray::flatten($args));
    // }

    // static public function wrapArray(array $array): ESArray
    // {
    //     return new ESArray($array);
    // }

    public function __construct(array $array)
    {
        $this->value = $array;
    }

    public function unwrap(): array
    {
        return $this->value;
    }

    private function array(): ESArray
    {
        return ESArray::wrap($this->value);
    }

//-> Describable
    public function description(): ESString
    {
        $valuesAsString = implode(", ", $this->value);
        return ESString::wrap("[{$valuesAsString}]");
    }

//-> plus/minus
    public function plus($array): ESArray
    {
        $suffix = $this->sanitizeTypeOrTriggerError($array, "array")->unwrap();
        $prefix = $this->unwrap();
        return ESArray::wrap(array_merge($prefix, $suffix));
    }

    public function minus($array): ESArray
    {
        $deletes = $this->sanitizeTypeOrTriggerError($array, "array")->unwrap();
        $copy = $this->unwrap();
        for ($i = 0; $i < count($this->unwrap()); $i++) {
            foreach ($deletes as $check) {
                if ($check === $copy[$i]) {
                    unset($copy[$i]);
                }
            }
        }
        return ESArray::wrap(array_values($copy));
    }
}
