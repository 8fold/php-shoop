<?php

namespace Eightfold\Shoop;

class ESArray extends ESBaseType implements
    \Iterator,
    \Countable
{
    // TODO: Implement ArrayAccess??

    public function __construct(...$values)
    {
        $this->value = $values;
    }

    public function description(): ESString
    {
        // TODO: Use base types
        $strings = [];
        for ($i = 0; $i < $this->count()->unwrap(); $i++) {
            $key = $i;
            $value = $this->value[$i];
            $strings[] = "{$key} => {$value}";
        }
        return Shoop::string("[". implode(", ", $strings) ."]");
    }

    private function enumerated(): ESArray
    {
        return ESArray::wrap(...array_values($this->value));
    }

    public function sorted(): ESArray
    {
        $array = $this->enumerated()->unwrap();
        natsort($array);
        return ESArray::wrap(...$array)->enumerated();
    }

    public function shuffled(): ESArray
    {
        $array = $this->enumerated()->unwrap();
        shuffle($array);
        return ESArray::wrap(...$array)->enumerated();
    }

    public function toggle(): ESArray
    {
        return ESArray::wrap(...array_reverse($this->enumerated()->unwrap()))->enumerated();
    }

    public function first()
    {
        $array = $this->enumerated()->unwrap();
        $value = array_shift($array);
        return parent::instanceFromValue($value);
    }

    public function last()
    {
        $array = $this->enumerated()->unwrap();
        $value = array_pop($array);
        return parent::instanceFromValue($value);
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
        return ESArray::wrap(...$array)->enumerated();
    }

    public function dropLast($length = 1): ESArray
    {
        $length = $this->sanitizeTypeOrTriggerError($length, "integer", ESInt::class)->unwrap();
        return $this->enumerated()->toggle()->dropFirst($length)->toggle()->enumerated();
    }

    public function removeEmptyValues(): ESArray
    {
        return ESArray::wrap(...array_filter($this->unwrap()))->enumerated();
    }

    public function plus(...$values): ESArray
    {
        $suffix = $this->sanitizeTypeOrTriggerError($values, "array", ESArray::class, true)->unwrap();
        $prefix = $this->unwrap();
        $merged = array_merge($prefix, $suffix);
        return ESArray::wrap(...$merged);
    }

    public function multipliedBy($multiplier): ESArray
    {
        $multiplier = $this->sanitizeTypeOrTriggerError(
                $multiplier,
                "integer",
                ESInt::class
            )->unwrap();
        $build = ESArray::wrap();
        for ($i = 1; $i <= $multiplier; $i++) {
            $build = $build->plus(...$this->unwrap());
        }
        return $build;
    }

    public function minus(...$values): ESArray
    {
        $deletes = $this->sanitizeTypeOrTriggerError(
            $values,
            "array",
            ESArray::class,
            true
        )->unwrap();
        $copy = $this->unwrap();
        for ($i = 0; $i < count($this->unwrap()); $i++) {
            foreach ($deletes as $check) {
                if ($check === $copy[$i]) {
                    unset($copy[$i]);
                }
            }
        }
        return ESArray::wrap(...array_values($copy));
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
        return ESArray::wrap(...$array)->enumerated();
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
                ESArray::class,
                true
            )->unwrap();
        $bisected = $this->dividedBy($int);
        $lhs = $bisected->lhs()->unwrap();
        $rhs = $bisected->rhs()->unwrap();
        $merged = array_merge($lhs, $value, $rhs);
        return ESArray::wrap(...$merged)->enumerated();
    }

    public function count(): ESInt
    {
        return ESInt::wrap(count($this->enumerated()->unwrap()));
    }

//-> Iterator
    public function current(): ESInt
    {
        $current = key($this->value);
        return ESInt::wrap($this->value[$current]);
    }

    public function key(): ESInt
    {
        return ESInt::wrap(key($this->value));
    }

    public function next(): ESArray
    {
        next($this->value);
        return $this;
    }

    public function rewind(): ESArray
    {
        reset($this->value);
        return $this;
    }

    /**
     * @return bool Must be bool for sake of PHP
     */
    public function valid(): bool
    {
        $key = key($this->value);
        $var = ($key !== null && $key !== false);
        return $var;
    }
}
