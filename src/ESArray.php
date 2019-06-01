<?php

namespace Eightfold\Shoop;

use Illuminate\Support\Arr as IlluminateArray;

use Eightfold\Shoop\{
    ESBaseType,
    ESString,
    ESRange,
    ESTuple,
    ESInt,
    ESBool
};

class ESArray extends ESBaseType implements
    \Countable
{
    public function description(): ESString
    {
        $valuesAsString = implode(", ", $this->value);
        return ESString::wrap("[{$valuesAsString}]");
    }

    private function enumerated(): ESArray
    {
        return ESArray::wrap(array_values($this->value));
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

    public function first()
    {
        $array = $this->enumerated()->unwrap();
        $value = array_shift($array);
        return parent::baseTypeForValue($value);
    }

    public function last()
    {
        $array = $this->enumerated()->unwrap();
        $value = array_pop($array);
        return parent::baseTypeForValue($value);
    }

    public function dropFirst($length = 1): ESArray
    {
        $length = $this->sanitizeTypeOrTriggerError($length, "integer", ESInt::class)->unwrap();

        // TODO:
        // $this->enumerated()->for(1, $length, function(&$array) {
        //  array_shift($array);
        // });
        $array = $this->enumerated()->unwrap();
        $range = ESRange::wrap(1, $length);
        foreach ($range as $i) {
            array_shift($array);
        }
        return ESArray::wrap($array)->enumerated();
    }

    public function dropLast($length = 1): ESArray
    {
        $length = $this->sanitizeTypeOrTriggerError($length, "integer", ESInt::class)->unwrap();
        return $this->enumerated()->toggle()->dropFirst($length)->toggle()->enumerated();
    }

    public function removeEmptyValues(): ESArray
    {
        return ESArray::wrap(array_filter($this->unwrap()))->enumerated();
    }

    public function plus($array): ESArray
    {
        $suffix = $this->sanitizeTypeOrTriggerError($array, "array")->unwrap();
        $prefix = $this->unwrap();
        return ESArray::wrap(array_merge($prefix, $suffix));
    }

    public function multipliedBy($multiplier): ESArray
    {
        $multiplier = $this->sanitizeTypeOrTriggerError(
                $multiplier,
                "integer",
                ESInt::class
            )->unwrap();
        $build = ESArray::wrap([]);
        for ($i = 1; $i <= $multiplier; $i++) {
            $build = $build->plus($this);
        }
        return $build;
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

    public function dividedBy($divisor): ESTuple
    {
        $divisor = $this->sanitizeTypeOrTriggerError(
                $divisor,
                "integer",
                ESInt::class
            )->unwrap();

        $left = array_slice($this->unwrap(), 0, $divisor);
        $right = array_slice($this->unwrap(), $divisor);

        return ESTuple::wrap("lhs", $left, "rhs", $right);
        return array($left, $right);
    }

    public function joined($delimiter = ""): ESString
    {
        $delimiter = $this->sanitizeTypeOrTriggerError(
                $delimiter,
                "string",
                ESString::class
            )->unwrap();
        return ESString::wrap(implode($delimiter, $this->unwrap()));
    }

    public function removeAtIndex($int): ESArray
    {
        $int = $this->sanitizeTypeOrTriggerError(
                $int,
                "integer",
                ESInt::class
            )->unwrap();
        $array = $this->unwrap();
        unset($array[$int]);
        return ESArray::wrap($array)->enumerated();
    }

    public function insertAtIndex($value, $int): ESArray
    {
        $int = $this->sanitizeTypeOrTriggerError(
                $int,
                "integer",
                ESInt::class
            )->unwrap();

        $value = $this->sanitizeTypeOrTriggerError(
                $value,
                "array",
                ESArray::class
            )->unwrap();
        $bisected = $this->dividedBy($int);
        $lhs = $bisected->lhs()->unwrap();
        $rhs = $bisected->rhs()->unwrap();
        return ESArray::wrap(array_merge($lhs, $value, $rhs))->enumerated();
    }

    public function count(): ESInt
    {
        return ESInt::wrap(count($this->enumerated()->unwrap()));
    }
}
