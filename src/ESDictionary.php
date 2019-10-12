<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Helpers\Type;

// TODO: get($key) - ESArray, ESDictionary
class ESDictionary implements
    \ArrayAccess,
    \Iterator,
    Shooped
{
    use ShoopedImp;

    public function isGreaterThan($compare): ESBool {}

    public function isGreaterThanOrEqual($compare): ESBool {}

    public function isLessThan($compare): ESBool {}

    public function isLessThanOrEqual($compare): ESBool {}

    public function multiply($int) {}

    // TODO: Test + possibly write combine()
    public function toggle()
    {
        $values = $this->enumerate()->toggle();
        $keys = $this->enumerateKeys()->toggle();
        $combined = array_combine($keys, $values);
        return Shoop::array($combined);
    }

    private function enumerateKeys(): ESArray
    {
        return Shoop::array(array_keys($this->value));
    }

    public function plus(...$args)
    {
        if (Shoop::array($args)->count()->isNotUnfolded(2)) {
            $className = ESDictionary::class;
            $count = Shoop::array($args)->count();
            trigger_error(
                "{$className}::plus() expects two arguments. {$count} given."
            );
        }

        $key = $this->sanitizeType($args[0], ESString::class)->unfold();

        $dict = $this->unfold();
        $dict[$key] = $args[1];
        return Shoop::dictionary($dict);
    }

    public function minus($value)
    {
        $key = Type::sanitizeType($value, ESString::class);
        unset($this[$key]);
        return Shoop::dictionary($this->unfold());
    }

    public function divide($value = null)
    {
        $keys = $this->enumerateKeys();
        $values = $this->enumerate();
        return Shoop::dictionary(["keys" => $keys, "values" => $values]);
    }

    public function isDivisible($value): ESBool
    {
        return Shoop::bool(count(array_keys($this->unfold())) > 0)
            ->and(count(array_values($this->unfold())) > 0);
    }

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


















    public function __construct($dictionary)
    {
        if (is_array($dictionary) && Type::isDictionary($dictionary)) {
            $this->value = $dictionary;

        } elseif (is_a($dictionary, ESDictionary::class)) {
            $this->value = $dictionary->unfold();

        } else {
            $this->value = [];

        }
    }

    public function enumerate(): ESArray
    {
        return Shoop::array(array_values($this->value));
    }

    private function validateCounts(array $args)
    {
        $keyCount = Shoop::array(array_keys($args))->count();
        $valueCount = Shoop::array(array_values($args))->count();
        if ($keyCount->isNot($valueCount)->unfold()) {
            trigger_error(
                "ESDictionary expects an even number of arguments. Using 0 index, 0 and even arguments are members (keys) while odd arguments are values. {$keyCount->unfold()} items were found.",
                E_USER_ERROR
            );
        }
    }

    public function hasKey($key): ESBool
    {
        $key = $this->sanitizeType($key, ESString::class)->unfold();
        return Shoop::bool($this->offsetExists($key));
    }

    public function doesNotHaveKey($key): ESBool
    {
        return $this->hasKey($key)->toggle();
    }

    public function valueForKey($key)
    {
        $key = $this->sanitizeType($key, ESString::class)->unfold();
        if (array_key_exists($key, $this->value)) {
            return $this->sanitizeType($this->value[$key]);
        }
        return null;
    }

    public function setValueForKey($key, $value): ESDictionary
    {
        $key = $this->sanitizeType($key, ESString::class)->unfold();
        $this[$key] = $value;
        return $this;
    }

    // public function removeKey($key): ESDictionary
    // {
    //     unset($this[$key]);
    //     return $this;
    // }

//-> ArrayAccess
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->value[] = $value;
        } else {
            $this->value[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->value[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->value[$offset]);
    }

    public function offsetGet($offset)
    {
        return ($this->offsetExists($offset))
            ? $this->value[$offset]
            : null;
    }

    public function toObject(): \stdClass
    {
        return (object) $this->value;
    }


//-> Iterator
    public function current(): ESInt
    {
        $current = key($this->value);
        return ESInt::fold($this->value[$current]);
    }

    public function key(): ESInt
    {
        return ESInt::fold(key($this->value));
    }

    public function next(): ESDictionary
    {
        next($this->value);
        return $this;
    }

    public function rewind(): ESDictionary
    {
        reset($this->value);
        return $this;
    }

    public function valid(): bool
    {
        $key = key($this->value);
        $var = ($key !== null && $key !== false);
        return $var;
    }
}
