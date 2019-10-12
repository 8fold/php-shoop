<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Interfaces\Shooped;

class ESArray implements
    \Iterator,
    Shooped
{
    use ShoopedImp;

    public function isGreaterThan($compare): ESBool {}

    public function isGreaterThanOrEqual($compare): ESBool {}

    public function isLessThan($compare): ESBool {}

    public function isLessThanOrEqual($compare): ESBool {}

    public function __construct($array = [])
    {
        if (is_a($array, ESArray::class)) {
            $array = $array->unfold();

        } elseif (! is_array($array)) {
            $array = [$array];

        }
        $this->value = $array;
    }

    public function sorted(): ESArray
    {
        $array = $this->enumerate()->unfold();
        natsort($array);
        return Shoop::array($array)->enumerate();
    }

    public function shuffle(): ESArray
    {
        $array = $this->enumerate()->unfold();
        shuffle($array);
        return Shoop::array($array)->enumerate();
    }

    public function toggle() // 7.4 : self
    {
        return Shoop::array(array_reverse($this->enumerate()->unfold()))->enumerate();
    }

    public function first()
    {
        $array = $this->enumerate()->unfold();
        $value = array_shift($array);
        if ($value === null) {
            return Shoop::array([]);

        }
        return Type::sanitizeType($value);
    }

    public function last()
    {
        return $this->toggle()->first();
    }

    public function dropFirst($length = 1): ESArray
    {
        $length = $this->sanitizeType($length, ESInt::class)->unfold();

        $array = $this->enumerate()->unfold();
        for ($i = 0; $i < $length; $i++) {
            array_shift($array);
        }
        return Shoop::array($array)->enumerate();
    }

    public function dropLast($length = 1): ESArray
    {
        return $this->enumerate()->toggle()->dropFirst($length)->toggle()->enumerate();
    }

    public function removeEmptyValues(): ESArray
    {
        return Shoop::array(array_filter($this->unfold()))->enumerate();
    }

    public function enumerate(): ESArray
    {
        return Shoop::array(array_values($this->value));
    }

    public function plus(...$args)
    {
        $count = count($args);
        switch ($count) {
            case 0:
                return Shoop::array($this->unfold());
                break;

            case 1:
                $args = Type::sanitizeType($args[0], ESArray::class)->unfold();
                $merged = array_merge($this->unfold(), $args);
                return Shoop::array($merged);
                break;
            
            default:
                $merged = array_merge($this->unfold(), $args);
                return Shoop::array($merged);
                break;
        }
    }

    public function prepend(...$args)
    {
        $args = Type::sanitizeType($args, ESArray::class)->unfold();
        return Shoop::array(array_merge($args[0], $this->unfold()));
    }

    // TODO: Test!!!!!
    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $catch;
        for ($i = 0; $i < $int; $i++) {
            $catch = $this->plus($this);
        }
        return $catch;
    }

    public function minus($values): ESArray
    {
        if (Type::isNotArray($values)) {
            $values = [$values];
        }
        $deletes = $this->sanitizeType($values, ESArray::class)->unfold();
        $copy = $this->unfold();
        for ($i = 0; $i < count($this->unfold()); $i++) {
            foreach ($deletes as $check) {
                if ($check === $copy[$i]) {
                    unset($copy[$i]);
                }
            }
        }
        return Shoop::array(array_values($copy));
    }

    public function divide($value = null)
    {
        $index = Type::sanitizeType($value, ESInt::class)->unfold();

        $left = array_slice($this->unfold(), 0, $index);
        $right = array_slice($this->unfold(), $index);

        return Shoop::array([$left, $right]);
    }

    public function isDivisible($value): ESBool
    {
        $index = Type::sanitizeType($value, ESInt::class)->unfold();
        return $index >= $this->count();
    }

    // public function append($values)
    // {
    //     return $this->plus($values);
    // }

    // public function prepend($value)
    // {
    //     if (! is_array($values)) {
    //         $values = [$values];
    //     }
    //     return Shoop::array(array_merge($values, $this->unfold());
    // }

    public function join($delimiter = ""): ESString
    {
        $delimiter = $this->sanitizeType($delimiter, ESString::class);
        return Shoop::string(implode($delimiter->unfold(), $this->unfold()));
    }

    public function removeAtIndex($int): ESArray
    {
        $int = $this->sanitizeType($int, ESInt::class)->unfold();
        $array = $this->unfold();
        unset($array[$int]);
        return Shoop::array($array)->enumerate();
    }

    public function insertAtIndex($value, $int): ESArray
    {
        $int = $this->sanitizeType($int, ESInt::class)->unfold();
        $value = $this->sanitizeType($value, ESArray::class)->unfold();

        $lhs = array_slice($this->unfold(), 0, $int);
        $rhs = array_slice($this->unfold(), $int);

        $merged = array_merge($lhs, $value, $rhs);
        return Shoop::array($merged)->enumerate();
    }

    public function hasValue($value): ESBool
    {
        return Shoop::bool(in_array($value, $this->value));
    }

    public function each(\Closure $closure): ESArray
    {
        $build = [];
        foreach ($this->value as $key => $value) {
            $consider = $closure($value, $key = "");
            if ($consider !== null) {
                $build[] = $consider;
            }
        }
        return Shoop::array($build);
    }

//-> Iterator
    public function current(): ESInt
    {
        $current = key($this->value);
        return Shoop::int($this->value[$current]);
    }

    public function key(): ESInt
    {
        return Shoop::int(key($this->value));
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
     * @return bool Must return bool for sake of PHP
     */
    public function valid(): bool
    {
        $key = key($this->value);
        $var = ($key !== null && $key !== false);
        return $var;
    }

//-> String
    public function __toString()
    {
        $printed = print_r($this->unfold(), true);
        $oneLine = preg_replace('/\s+/', ' ', $printed);
        $commas = str_replace(
            [" [", " ) ", " (, "], 
            [", [", ")", "("], 
            $oneLine);
        return $commas;
    }
}
