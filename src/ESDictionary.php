<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\ESInt;

// TODO: get($key) - ESArray, ESDictionary
class ESDictionary implements
    \Iterator,
    Shooped
{
    use ShoopedImp;

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

    // TODO: Test + possibly write combine()
    // TODO: Alias called values
    public function array(): ESArray
    {
        return Shoop::array(array_values($this->value));
    }

   /**
     * @deprecated
     */
    public function enumerate(): ESArray
    {
        return $this->array();
    }

    public function dictionary(): ESDictionary
    {
        return $this;
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

    public function toggle()
    {
        $values = $this->array()->toggle();
        $keys = $this->keys()->toggle();
        $combined = array_combine($keys, $values);
        return Shoop::array($combined);
    }

    public function sort()
    {
        $array = $this->unfold();
        natsort($array);
        return Shoop::dictionary($array);
    }

    public function shuffle()
    {
        $array = $this->unfold();
        shuffle($array);
        return Shoop::dictionary($array);
    }

    public function startsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle, ESArray::class)->unfold();
        $count = 0;
        foreach ($needle as $val) {
            if ($this->contains($val)->toggleUnfolded()) {
                return Shoop::bool(false);
            }
        }
        return Shoop::bool(true);
    }

    public function endsWith($needle): ESBool
    {
        return $this->startsWith($needle);
    }

    public function start(...$prefixes)
    {
        return $this->plus(...$prefixes);
    }

    public function divide($value = null)
    {
        $keys = $this->enumerateKeys();
        $values = $this->enumerate();
        return Shoop::dictionary(["keys" => $keys, "values" => $values]);
    }

    public function minus($value)
    {
        $key = Type::sanitizeType($value, ESString::class);
        unset($this[$key]);
        return Shoop::dictionary($this->unfold());
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

    // Todo: Test
    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $array = Shoop::array([]);
        for ($i = 0; $i < $int; $i++) {
            $array[] = $this;
        }
        return $array;
    }




























    private function keys(): ESArray
    {
        return Shoop::array(array_keys($this->value));
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
        $key = Type::sanitizeType($key, ESString::class)->unfold();
        return Shoop::bool($this->offsetExists($key));
    }

    public function doesNotHaveKey($key): ESBool
    {
        return $this->hasKey($key)->toggle();
    }

    public function valueForKey($key)
    {
        $key = Type::sanitizeType($key, ESString::class)->unfold();
        if (array_key_exists($key, $this->value)) {
            return Type::sanitizeType($this->value[$key]);
        }
        return null;
    }

    public function setValueForKey($key, $value): ESDictionary
    {
        $key = $this->sanitizeType($key, ESString::class)->unfold();
        $this[$key] = $value;
        return $this;
    }
}
