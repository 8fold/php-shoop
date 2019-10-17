<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Interfaces\Shooped;

class ESArray implements Shooped
{
    use ShoopedImp;

    public function __construct($array = [])
    {
        if (is_a($array, ESArray::class)) {
            $array = $array->unfold();

        } elseif (! is_array($array)) {
            $array = [$array];

        }
        $this->value = $array;
    }

// - Type Juggling
    public function string(): ESString
    {
        $printed = print_r($this->unfold(), true);
        $oneLine = preg_replace('/\s+/', ' ', $printed);
        $commas = str_replace(
            [" [", " ) ", " (, "],
            [", [", ")", "("],
            $oneLine);
        return Shoop::string($commas);
    }

    public function array(): ESArray
    {
        return Shoop::array(array_values($this->value));
    }

    public function dictionary(): ESDictionary
    {
        $build = [];
        foreach ($this->value as $key => $value) {
            $key = "i". $key;
            $build[$key] = $value;
        }
        return Shoop::dictionary($build);
    }

    /**
     * @deprecated
     */
    public function enumerate(): ESArray
    {
        return $this->array();
    }

// - PHP single-method interfaces
// - Manipulate
    public function start(...$prefixes)
    {
        $prefixes = Type::sanitizeType($prefixes)->unfold();
        $merged = array_merge($prefixes, $this->unfold());
        return Shoop::array($merged);
    }

// - Search
    public function startsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle, ESArray::class)->unfold();
        $count = 0;
        foreach ($needle as $val) {
            $array = $this->unfold();
            if (isset($array[$count]) && $array[$count] !== $val) {
                return Shoop::bool(false);
            }
            $count++;
        }
        return Shoop::bool(true);
    }

    public function endsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle, ESArray::class)->toggle();
        $reversed = $this->toggle();
        return $reversed->startsWith($needle);
    }

// - Math language
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

    public function minus(...$args): ESArray
    {
        if (Type::isNotArray($values)) {
            $values = [$values];
        }
        $deletes = Type::sanitizeType($args, ESArray::class)->unfold();
        $copy = $this->unfold();
        for ($i = 0; $i < $this->countUnfolded(); $i++) {
            foreach ($deletes as $check) {
                if ($check === $copy[$i]) {
                    unset($copy[$i]);
                }
            }
        }
        return Shoop::array(array_values($copy));
    }

    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $catch;
        for ($i = 0; $i < $int; $i++) {
            if ($catch === null) {
                $catch = $this->plus(...$this->unfold());

            } else {
                $catch = $catch->plus(...$this->unfold());

            }
        }
        return $catch;
    }

    public function divide($value = null)
    {
        $index = Type::sanitizeType($value, ESInt::class)->unfold();

        $left = array_slice($this->unfold(), 0, $index);
        $right = array_slice($this->unfold(), $index);

        return Shoop::array([$left, $right]);
    }

// - Comparison
// - Getters
    public function get($member)
    {
        $member = Type::sanitizeType($member, ESInt::class)->unfold();
        if ($this->hasMember($member)) {
            return Shoop::this($this[$member]);
        }
        trigger_error("Undefined index or memember.");
    }

    private function members(): ESArray
    {
        return Shoop::array(array_keys($this->value));
    }

    public function values(): ESArray
    {
        return $this->array();
    }

    public function last()
    {
        return $this->toggle()->first();
    }

// - Other
    // TODO: Promote to ShoopedImp, with custom for ESString
    public function hasMember($member): ESBool
    {
        $member = Type::sanitizeType($member, ESInt::class)->unfold();
        return Shoop::bool($this->offsetExists($member));
    }

    public function doesNotHaveMember($member): ESBool
    {
        return $this->hasMember($member)->toggle();
    }

    public function join($delimiter = ""): ESString
    {
        $delimiter = Type::sanitizeType($delimiter, ESString::class);
        return Shoop::string(implode($delimiter->unfold(), $this->unfold()));
    }

    public function insertAt($value, $int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $value = Type::sanitizeType($value, ESArray::class)->unfold();

        $lhs = array_slice($this->unfold(), 0, $int);
        $rhs = array_slice($this->unfold(), $int);

        $merged = array_merge($lhs, $value, $rhs);
        return Shoop::array($merged)->enumerate();
    }

    public function drop($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $array = $this->unfold();
        unset($array[$int]);
        return Shoop::array($array)->enumerate();
    }

    public function dropFirst($length = 1): ESArray
    {
        $length = Type::sanitizeType($length, ESInt::class)->unfold();

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

    public function noEmpties(): ESArray
    {
        return Shoop::array(array_filter($this->unfold()))->enumerate();
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
}
