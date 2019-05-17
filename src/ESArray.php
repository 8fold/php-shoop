<?php

namespace Eightfold\Shoop;

use Illuminate\Support\Arr as IlluminateArray;

use Eightfold\Shoop\{
    ESBaseType,
    ESString,
    ESRange,
    ESInt,
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
    Storeable
{
    use
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

    private function enumerated(): ESArray
    {
        return ESArray::wrap(array_values($this->value));
    }

    public function count(): ESInt
    {
        return ESInt::wrap(count($this->enumerated()->unwrap()));
    }

    public function sorted(): ESArray
    {
        $array = $this->enumerated()->unwrap();
        natsort($array);
        return ESArray::wrap($array)->enumerated();
    }

    public function shuffled(): ESArray
    {
        $array = $this->enumerated()->unwrap();
        shuffle($array);
        return ESArray::wrap($array)->enumerated();
    }

    public function toggle(): ESArray
    {
        return ESArray::wrap(array_reverse($this->enumerated()->unwrap()))->enumerated();
    }

    private function minMax($value)
    {
        $typeMap = [
            "boolean" => ESBool::class,
            "integer" => ESInt::class,
            "string" => ESString::class,
            "array" => ESArray::class
            //"double" (for historical reasons "double" is returned in case of a float, and not simply "float")
            // "object"
            // "resource"
            // "resource (closed)" as of PHP 7.2.0
            // "NULL"
            // "unknown type"
        ];

        $type = gettype($value);
        if (array_key_exists($type, $typeMap) && $value !== null) {
            $class = $typeMap[$type];
            return $class::wrap($value);
        }
        return $this;
    }

    public function min()
    {
        $array = $this->enumerated()->unwrap();
        $value = array_shift($array);
        return $this->minMax($value);
    }

    public function first()
    {
        return $this->min();
    }

    public function max()
    {
        $array = $this->enumerated()->unwrap();
        $value = array_pop($array);
        return $this->minMax($value);
    }

    public function last()
    {
        return $this->max();
    }

    public function dropFirst($length = 1): ESArray
    {
        $length = $this->sanitizeTypeOrTriggerError($length, "integer", ESInt::class)->unwrap();

        $array = $this->enumerated()->unwrap();
        $range = ESRange::wrap(1, $length);
        foreach ($range as $i) {
            array_shift($array);
        }
        return ESArray::wrap($array)->enumerated();
    }

    public function dropLast($length = 1): ESArray
    {
        return $this->enumerated()->toggle()->dropFirst($length)->toggle()->enumerated();
    }

    public function startsWith($compare): ESBool
    {
        $compare = $this->sanitizeTypeOrTriggerError($compare, "array", ESArray::class);
        $length = $compare->count()->unwrap();
        $array = ESArray::wrap(array_slice($this->enumerated()->unwrap(), 0, $length));
        return $array->isSameAs($compare);
    }

    public function endsWith($compare)
    {
        $compare = $this->sanitizeTypeOrTriggerError($compare, "array", ESArray::class)->toggle();
        $reversed = $this->toggle();
        return $reversed->startsWith($compare);
    }

    public function removeEmptyValues(): ESArray
    {
        return ESArray::wrap(array_filter($this->unwrap()))->enumerated();
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
