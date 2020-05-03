<?php

namespace Eightfold\Shoop\Traits;

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

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Helpers\Type;

trait ShoopedImp
{
    protected $value;

    protected $dictionary;

    static public function fold($args)
    {
        return new static($args);
    }

    public function unfold()
    {
        // Preserve Shoop internally: unfold($preserve = false)
        // only implement if needed; otherwise, we're good.
        $return = (isset($this->temp)) ? $this->temp : $this->value;
        if (Type::isArray($return) || Type::isDictionary($return)) {
            $array = $return;
            $return = [];
            foreach ($array as $key => $value) {
                // preserve if (! $preserve && Type::isShooped($value)) {
                if (Type::isShooped($value)) {
                    $value = $value->unfold();
                }
                $return[$key] = $value;
            }
        }
        return $return;
    }

// - Type Juggling
    public function array(): ESArray
    {
        if (Type::is($this, ESArray::class, ESDictionary::class)) {
            $array = $this->value;

        } elseif (Type::is($this, ESBool::class)) {
            $array = [$this->value];

        } elseif (Type::is($this, ESInt::class)) {
            $array = $this->range()->unfold();

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->value;
            $array = $this->stringToIndexedArray($string);

        } elseif (Type::is($this, ESObject::class)) {
            $array = (array) $this->value;

        } elseif (Type::is($this, ESJson::class)) {
            $array = (array) json_decode($this->value);

        }
        $values = $this->arrayValuesFromIndexedArray($array);
        return Shoop::array($values);
    }

    public function bool(): ESBool
    {
        if (Type::is($this, ESArray::class)) {
            $array = $this->value;
            $bool = count($array) > 0;
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESBool::class)) {
            $bool = $this->value;
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->value;
            $bool = count($array) > 0;
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESInt::class)) {
            $int = $this->value;
            $bool = $int > 0;
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESJson::class)) {
            $json = $this->value;
            $object = json_decode($json);
            $array = (array) $object;
            $bool = count($array) > 0;
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->value;
            $array = (array) $object;
            $bool = count($array) > 0;
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->value;
            $bool = empty($string);
            $bool = ! $bool;
            return Shoop::bool($bool);

        }
    }

    public function dictionary(): ESDictionary
    {
        if (Type::is($this, ESDictionary::class)) {
            $dictionary = $this->value;

        } elseif (Type::is($this, ESArray::class)) {
            $array = $this->value;
            $dictionary = $this->indexedArrayToAssociativeArray($array);

        } elseif (Type::is($this, ESBool::class)) {
            $bool = $this->value;
            $dictionary = $this->boolToAssociativeArray($bool);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->unfold();
            $dictionary = (array) $object;

        } elseif (Type::is($this, ESInt::class)) {
            $array = $this->range()->unfold();
            $dictionary = $this->indexedArrayToAssociativeArray($array);

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->value;
            $array = $this->stringToIndexedArray($string);
            $dictionary = $this->indexedArrayToAssociativeArray($array);

        } elseif (Type::is($this, ESJson::class)) {
            $decoded = json_decode($this->value);
            $dictionary = (array) $decoded;

        }
        return Shoop::dictionary($dictionary);
    }

    public function int(): ESInt
    {
        if (Type::is($this, ESArray::class, ESDictionary::class)) {
            $array = $this->value;
            $int = count($array);
            return Shoop::int($int);

        } elseif (Type::is($this, ESBool::class)) {
            $bool = $this->value;
            $int = $this->value
                ? 1
                : 0;
            return Shoop::int($int);

        } elseif (Type::is($this, ESInt::class)) {
            $int = $this->value;
            return Shoop::int($int);

        } elseif (Type::is($this, ESJson::class)) {
            $json = $this->value;
            $object = json_decode($json);
            $array = (array) $object;
            $int = count($array);
            return Shoop::int($int);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->value;
            $array = (array) $object;
            $int = count($array);
            return Shoop::int($int);

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->value;
            $int = intval($string);
            return Shoop::int($int);

        }
    }

    public function json(): ESJson
    {
        $json = "";
        if (Type::is($this, ESJson::class, ESString::class)) {
            $json = $this->value;

        } elseif (Type::is($this, ESObject::class)) {
            $json = json_encode($this->value);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->value;
            $json = $this->arrayToJsonEncodedString($array);

        } elseif (Type::is($this, ESArray::class)) {
            $array = $this->value;
            $json = $this->indexedArrayToJsonEncodedString($array);

        } elseif (Type::is($this, ESBool::class)) {
            $bool = $this->value;
            $dictionary = $this->boolToAssociativeArray($bool);
            $json = $this->arrayToJsonEncodedString($dictionary);

        } elseif (Type::is($this, ESInt::class)) {
            $array = $this->range()->unfold();
            $json = $this->indexedArrayToJsonEncodedString($array);

        }
        return Shoop::json($json);
    }

    public function object(): ESObject
    {
        $object = null;
        if (Type::is($this, ESArray::class)) {
            $array = $this->value;
            $object = $this->associativeArrayToObject($array);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->value;

        } elseif (Type::is($this, ESJson::class)) {
            $string = $this->value;
            $object = json_decode($string);

        } elseif (Type::is($this, ESDictionary::class)) {
            $dictionary = $this->value;
            $object = (object) $dictionary;

        } elseif (Type::is($this, ESBool::class)) {
            $bool = $this->value;
            $dictionary = $this->boolToAssociativeArray($bool);
            $object = (object) $dictionary;

        } elseif (Type::is($this, ESInt::class)) {
            $array = $this->range()->unfold();
            $object = $this->associativeArrayToObject($array);

        } elseif (Type::is($this, ESString::class)) {
            $object = (object) $this->value;

        }
        return Shoop::object($object);
    }

    public function string(): ESString
    {
        $string = "";
        if (Type::is($this, ESString::class)) {
            $string = $this->value;

        } elseif (Type::is($this, ESObject::class)) {
            $array = (array) $this->value;
            $arrayString = $this->arrayToRecursiveString($array);
            $string = str_replace("Array(", "stdClass Object(", $arrayString);

        } elseif (Type::is($this, ESInt::class)) {
            $string = "{$this->value}";

        } elseif (Type::is($this, ESArray::class, ESDictionary::class)) {
            $array = $this->value;
            $string = $this->arrayToRecursiveString($array);

        } elseif (Type::is($this, ESBool::class)) {
            $string = ($this->unfold()) ? "true" : "";

        } elseif (Type::is($this, ESJson::class)) {
            $string = $this->value;

        }
        return Shoop::string($string);
    }

    private function indexedArrayToAssociativeArray(array $array = []): array
    {
        $build = [];
        foreach ($array as $key => $value) {
            $key = "i". $key;
            $build[$key] = $value;
        }
        return $build;
    }

    // TODO: Move to a helper class per DRY
    private function arrayValuesFromIndexedArray(array $array = []): array
    {
        return array_values($array);
    }

    private function stringToIndexedArray(string $string = ""): array
    {
        return preg_split('//u', $this->value, null, PREG_SPLIT_NO_EMPTY);
    }

    private function boolToAssociativeArray(bool $bool = true): array
    {
        return ($this->unfold() === true)
            ? ["true" => true, "false" => false]
            : ["true" => false, "false" => true];
    }

    private function arrayToJsonEncodedString(array $array = []): string
    {
        $object = (object) $array;
        $json = json_encode($object);
        return $json;
    }

    private function indexedArrayToJsonEncodedString(array $array): string
    {
        $dictionary = $this->indexedArrayToAssociativeArray($array);
        $json = $this->arrayToJsonEncodedString($dictionary);
        return $json;
    }

    private function associativeArrayToObject(array $array): \stdClass
    {
        $dictionary = $this->indexedArrayToAssociativeArray($array);
        $object = (object) $dictionary;
        return $object;
    }

    private function arrayToRecursiveString(array $array): string
    {
        $printed = print_r($array, true);
        $oneLine = preg_replace('/\s+/', ' ', $printed);
        $commas = str_replace(
            [" [", " ) ", " (, "],
            [", [", ")", "("],
            $oneLine);
        $fixSpacingWhenEmpty = preg_replace('/\s+\(/', "(", $commas, 1);
        return trim($fixSpacingWhenEmpty);
    }

// - Manipulating
// - Math language
// - Comparison
    public function is($compare): ESBool
    {
        if (Type::isNotShooped($compare)) {
            $compare = Type::sanitizeType($compare, static::class);
        }
        $bool = $this->unfold() === $compare->unfold();
        return Shoop::bool($bool);
    }

    public function isNot($compare): ESBool
    {
        $bool = $this->is($compare)->unfold();
        $bool = ! $bool;
        return Shoop::bool($bool);
    }

    public function isEmpty(): ESBool
    {
        return Shoop::bool(Type::isEmpty($this));
    }

// - Setters/Getters
    public function get($member = 0)
    {
        if (Type::is($this, ESArray::class)) {
            $member = Type::sanitizeType($member, ESInt::class)->unfold();
            $array = $this->value;
            $value = $this->valueFromArray($array, $member);
            return $value;

        } elseif (Type::is($this, ESBool::class)) {
            $bool = $this->value;
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESDictionary::class)) {
            $member = Type::sanitizeType($member, ESString::class)->unfold();
            $array = $this->value;
            $value = $this->valueFromArray($array, $member);
            return $value;

        } elseif (Type::is($this, ESInt::class)) {
            $member = Type::sanitizeType($member, ESInt::class)->unfold();
            $int = $this->value;
            $array = $this->range()->unfold();
            $value = $this->valueFromArray($array, $member);
            return $value;

        } elseif (Type::is($this, ESJson::class)) {
            $member = Type::sanitizeType($member, ESString::class)->unfold();
            $json = $this->value;
            $object = json_decode($json);
            $array = (array) $object;
            $value = $this->valueFromArray($array, $member);
            return $value;

        } elseif (Type::is($this, ESObject::class)) {
            $member = Type::sanitizeType($member, ESString::class)->unfold();
            $object = $this->value;
            $array = (array) $object;
            $value = $this->valueFromArray($array, $member);
            return $value;

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->value;
            $array = $this->stringToIndexedArray($string);
            $value = $this->valueFromArray($array, $member);
            return Shoop::string($value);

        }
    }

    public function set($value, $member = null, $overwrite = true)
    {
        if (Type::is($this, ESArray::class, ESDictionary::class)) {
            $array = $this->value;
            $array = $this->arrayAfterSettingValue($array, $value, $member, $overwrite);
            return (Type::is($this, ESArray::class))
                ? Shoop::array($array)
                : Shoop::dictionary($array);

        } elseif (Type::is($this, ESBool::class, ESString::class)) {
            $v = $this->value;
            $v = (Type::is($this, ESBool::class))
                ? Type::sanitizeType($value, ESBool::class)->unfold()
                : Type::sanitizeType($value, ESString::class)->unfold();
            return (Type::is($this, ESBool::class))
                ? Shoop::bool($v)
                : Shoop::string($v);

        } elseif (Type::is($this, ESInt::class)) {
            $int = $this->value;
            $int = Type::sanitizeType($value, ESInt::class)->unfold();
            return Shoop::int($int);

        } elseif (Type::is($this, ESJson::class)) {
            $json = $this->value;
            $object = json_decode($json);
            $array = (array) $object;
            $array = $this->arrayAfterSettingValue($array, $value, $member, $overwrite);
            $object = (object) $array;
            $json = json_encode($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->value;
            $array = (array) $object;
            $array = $this->arrayAfterSettingValue($array, $value, $member, $overwrite);
            $object = (object) $array;
            return Shoop::object($object);
        }
    }

    private function arrayAfterSettingValue(array $array, $value, $member, bool $overwrite): array
    {
        if ($member === null) {
            trigger_error("Setting value on array requires member be specified.");
        }
        $member = (Type::is($this, ESArray::class))
            ? Type::sanitizeType($member, ESInt::class)->unfold()
            : Type::sanitizeType($member, ESString::class)->unfold();
        $overwrite = Type::sanitizeType($overwrite, ESBool::class)->unfold();

        if ($this->offsetExists($member) && $overwrite) {
            $set = [$member => $value];
            $array = array_replace($array, $set);

        } elseif ($overwrite) {
            $set = [$member => $value];
            $array = array_replace($array, $set);

        } else {
            $array[$member] = $value;

        }
        return $array;
    }

    private function handleSet($name, $args)
    {
        $name = lcfirst(str_replace("set", "", $name));
        $overwrite = (isset($args[1])) ? $args[1] : true;
        $value = (isset($args[0])) ? $args[0] : null;

        return $this->set($value, $name, $overwrite);
    }

    private function handleGetUnfolded($name, $args)
    {
        $value;
        if (! method_exists($this, $name)) {
            $className = static::class;
            trigger_error("{$name} is an invalid method on {$className}", E_USER_ERROR);

        } elseif ($name === "plus" || $name === "minus") {
            $value = $this->{$name}(...$args);

        } else {
            $value = $this->{$name}($args[0]);

        }
        return (Type::isShooped($value)) ? $value->unfold() : $value;
    }

    private function valueFromArray(array $array, $member)
    {
        if (! $this->offsetExists($member)) {
            trigger_error("Undefined index or member.");
        }

        $value = $this[$member];
        if (Type::isPhp($value)) {
            return Type::sanitizeType($value);

        } else {
            return $m;

        }
    }

// - Callers
    public function __call($name, $args = [])
    {
        $startsWithSet = substr($name, 0, strlen("set")) === "set";
        $startsWithGet = substr($name, 0, strlen("get")) === "get";
        $endsWithUnfolded = substr($name, -(strlen("Unfolded"))) === "Unfolded";
        $name = Shoop::string($name)->unfold();
        if ($name === "getUnfolded") {
            $name = str_replace("Unfolded", "", $name);
            return $this->handleGetUnfolded($name, $args);

        } elseif ($startsWithSet) {
            $name = lcfirst(str_replace("set", "", $name));
            return $this->handleSet($name, $args);

        } elseif ($startsWithGet) {
            $name = lcfirst(str_replace("get", "", $name));
            return $this->get($name, $args);

        } elseif ($endsWithUnfolded) {
            $name = str_replace("Unfolded", "", $name);
            $value = $this->{$name}(...$args);
            return (Type::isShooped($value))
                ? $value->unfold()
                : $value;

        } elseif (is_callable([$this, "get"])) {
            $value = $this->get($name);
            $return = (isset($value) && Type::isShooped($value))
                ? $value->unfold()
                : $value;
            return $return;

        }
        trigger_error("Call to undefined method '{$name}'", E_USER_ERROR);
    }

// - PHP single-method interfaces
    public function __toString()
    {
        return $this->string()->unfold();
    }

// -> Array Access
    public function offsetExists($offset): bool
    {
        if (Type::is($this, ESBool::class)) {
            return $this->value;

        } elseif (Type::is($this, ESInt::class)) {
            return $this->array()->offsetExists($offset);

        } elseif (Type::is($this, ESJson::class, ESObject::class)) {
            return $this->dictionary()->offsetExists($offset);

        }
        return isset($this->value[$offset]);
    }

    public function offsetGet($offset)
    {
        if (Type::is($this, ESBool::class)) {
            return $this->dictionary()->offsetGet($offset);

        } elseif (Type::is($this, ESInt::class)) {
            return $this->array()->offsetGet($offset);

        } elseif (Type::is($this, ESJson::class, ESObject::class)) {
            return $this->dictionary()->offsetGet($offset);

        } elseif ($this->offsetExists($offset)) {
            return $this->value[$offset];

        }
        trigger_error("Undefined offset: {$offset}", E_USER_ERROR);
    }

    public function offsetSet($offset, $value): void
    {
        if (Type::is($this, ESInt::class, ESBool::class)) {
            $this->value = $value;

        } elseif (Type::is($this, ESJson::class)) {
            $object = json_decode($this->value);
            $object->{$offset} = $value;
            $this->value = json_encode($object);

        } elseif (Type::is($this, ESObject::class)) {
            $this->value->{$offset} = $value;

        } else {
            $this->value[$offset] = $value;

        }
    }

    public function offsetUnset($offset): void
    {
        if (Type::is($this, ESString::class)) {
            $array = $this->array();
            $array->offsetUnset($offset);
            $this->value = join("", $array->unfold());

        } elseif (Type::is($this, ESObject::class)) {
            unset($this->value->{$offset});

        } elseif (Type::is($this, ESJson::class)) {
            $object = json_decode($this->value);
            unset($object->{$offset});
            $this->value = json_encode($object);

        } else {
            unset($this->value[$offset]);

        }
    }

//-> Iterator
    private $temp;

    /**
     * rewind() -> valid() -> current() -> key() -> next() -> valid()...repeat
     *
     * Same implementation for Object, Dictionary, JSON
     *
     * @return [type] [description]
     */
    public function rewind(): void
    {
        if (Type::is($this, ESObject::class, ESDictionary::class, ESJson::class, ESBool::class)) {
            $this->temp = $this->dictionary()->unfold();

        } else {
            $this->temp = $this->array()->unfold();

        }
    }

    public function valid(): bool
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        return array_key_exists(key($this->temp), $this->temp);
    }

    public function current()
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        $temp = $this->temp;
        $key = key($temp);
        return $temp[$key];
    }

    public function key()
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        $temp = $this->temp;
        $key = key($temp);
        if (is_int($key)) {
            return Type::sanitizeType($key, ESInt::class, "int")->unfold();
        }
        return Type::sanitizeType($key, ESString::class, "string")->unfold();
    }

    public function next(): void
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        next($this->temp);
    }
}
