<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    ESBool,
    ESDictionary,
    ESInt,
    ESJson,
    ESObject,
    ESString
};

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Helpers\Type;
use Eightfold\Shoop\Helpers\PhpTypeJuggle;

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

    // TODO: static public function toggleFromTo()
    // TODO: public function toggleTo()
    private function juggleTo(string $className)
    {
        $value = null;
        if (Type::is($this, ESArray::class)) {
            if ($className === ESArray::class) {
                $value = $this->value;

            } elseif ($className === ESBool::class) {
                $value = PhpTypeJuggle::indexedArrayToBool($this->value);

            } elseif ($className === ESDictionary::class) {
                $value = PhpTypeJuggle::indexedArrayToAssociativeArray($this->value);

            } elseif ($className === ESInt::class) {
                $value = PhpTypeJuggle::indexedArrayToInt($this->value);

            } elseif ($className === ESJson::class) {
                $value = PhpTypeJuggle::indexedArrayToJson($this->value);

            } elseif ($className === ESObject::class) {
                $value = PhpTypeJuggle::indexedArrayToObject($this->value);

            } elseif ($className === ESString::class) {
                $value = PhpTypeJuggle::indexedArrayToString($this->value);

            }

        } elseif (Type::is($this, ESBool::class)) {
            if ($className === ESArray::class) {
                $value = PhpTypeJuggle::boolToIndexedArray($this->value);

            } elseif ($className === ESBool::class) {
                $value = $this->value;

            } elseif ($className === ESDictionary::class) {
                $value = PhpTypeJuggle::boolToAssociativeArray($this->value);

            } elseif ($className === ESInt::class) {
                $value = PhpTypeJuggle::boolToInt($this->value);

            } elseif ($className === ESJson::class) {
                $value = PhpTypeJuggle::boolToJson($this->value);

            } elseif ($className === ESObject::class) {
                $value = PhpTypeJuggle::boolToObject($this->value);

            } elseif ($className === ESString::class) {
                $value = PhpTypeJuggle::boolToString($this->value);

            }

        } elseif (Type::is($this, ESDictionary::class)) {
            if ($className === ESArray::class) {
                $value = PhpTypeJuggle::associativeArrayToIndexedArray($this->value);

            } elseif ($className === ESBool::class) {
                $value = PhpTypeJuggle::associativeArrayToBool($this->value);;

            } elseif ($className === ESDictionary::class) {
                $value = $this->value;

            } elseif ($className === ESInt::class) {
                $value = PhpTypeJuggle::associativeArrayToInt($this->value);

            } elseif ($className === ESJson::class) {
                $value = PhpTypeJuggle::associativeArrayToJson($this->value);

            } elseif ($className === ESObject::class) {
                $value = PhpTypeJuggle::associativeArrayToObject($this->value);

            } elseif ($className === ESString::class) {
                $value = PhpTypeJuggle::associativeArrayToString($this->value);

            }

        } elseif (Type::is($this, ESInt::class)) {
            if ($className === ESArray::class) {
                $value = PhpTypeJuggle::intToIndexedArray($this->value);

            } elseif ($className === ESBool::class) {
                $value = PhpTypeJuggle::intToBool($this->value);

            } elseif ($className === ESDictionary::class) {
                $value = PhpTypeJuggle::intToAssociativeArray($this->value);

            } elseif ($className === ESInt::class) {
                $value = $this->value;

            } elseif ($className === ESJson::class) {
                $value = PhpTypeJuggle::intToJson($this->value);

            } elseif ($className === ESObject::class) {
                $value = PhpTypeJuggle::intToObject($this->value);

            } elseif ($className === ESString::class) {
                $value = PhpTypeJuggle::intToString($this->value);

            }

        } elseif (Type::is($this, ESJson::class)) {
            if ($className === ESArray::class) {
                $value = PhpTypeJuggle::jsonToIndexedArray($this->value);

            } elseif ($className === ESBool::class) {
                $value = PhpTypeJuggle::jsonToBool($this->value);

            } elseif ($className === ESDictionary::class) {
                $value = PhpTypeJuggle::jsonToAssociativeArray($this->value);

            } elseif ($className === ESInt::class) {
                $value = PhpTypeJuggle::jsonToInt($this->value);

            } elseif ($className === ESJson::class) {
                $value = $this->value;

            } elseif ($className === ESObject::class) {
                $value = PhpTypeJuggle::jsonToObject($this->value);

            } elseif ($className === ESString::class) {
                $value = $this->value;

            }

        } elseif (Type::is($this, ESObject::class)) {
            if ($className === ESArray::class) {
                $value = PhpTypeJuggle::objectToIndexedArray($this->value);

            } elseif ($className === ESBool::class) {
                $value = PhpTypeJuggle::objectToBool($this->value);

            } elseif ($className === ESDictionary::class) {
                $value = PhpTypeJuggle::objectToAssociativeArray($this->value);

            } elseif ($className === ESInt::class) {
                $value = PhpTypeJuggle::objectToInt($this->value);

            } elseif ($className === ESJson::class) {
                $value = PhpTypeJuggle::objectToJson($this->value);

            } elseif ($className === ESObject::class) {
                $value = $this->value;

            } elseif ($className === ESString::class) {
                $value = PhpTypeJuggle::objectToString($this->value);

            }

        } elseif (Type::is($this, ESString::class)) {
            if ($className === ESArray::class) {
                $value = PhpTypeJuggle::stringToIndexedArray($this->value);

            } elseif ($className === ESBool::class) {
                $value = PhpTypeJuggle::stringToBool($this->value);

            } elseif ($className === ESDictionary::class) {
                $value = PhpTypeJuggle::stringToAssociativeArray($this->value);

            } elseif ($className === ESInt::class) {
                $value = PhpTypeJuggle::stringToInt($this->value);

            } elseif ($className === ESJson::class) {
                $value = $this->value;

            } elseif ($className === ESObject::class) {
                $value = PhpTypeJuggle::stringToObject($this->value);

            } elseif ($className === ESString::class) {
                $value = $this->value;

            }
        }

        if ($value === null) {
            trigger_error(get_class($this) ." cannot be converted to ". $className);
        }
        return $value;
    }

    public function array(): ESArray
    {
        $array = $this->juggleTo(ESArray::class);
        return Shoop::array($array);
    }

    public function bool(): ESBool
    {
        $bool = $this->juggleTo(ESBool::class);
        return Shoop::bool($bool);
    }

    public function dictionary(): ESDictionary
    {
        $dictionary = $this->juggleTo(ESDictionary::class);
        return Shoop::dictionary($dictionary);
    }

    public function int(): ESInt
    {
        $int = $this->juggleTo(ESInt::class);
        return Shoop::int($int);
    }

    public function json(): ESJson
    {
        $json = $this->juggleTo(ESJson::class);
        return Shoop::json($json);
    }

    public function object(): ESObject
    {
        $object = $this->juggleTo(ESObject::class);
        return Shoop::object($object);
    }

    public function string(): ESString
    {
        $string = $this->juggleTo(ESString::class);
        return Shoop::string($string);
    }

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
            $array = PhpTypeJuggle::intToIndexedArray($this->value);
            $value = $this->valueFromArray($array, $member);
            return $value;

        } elseif (Type::is($this, ESJson::class)) {
            $member = Type::sanitizeType($member, ESString::class)->unfold();
            $array = PhpTypeJuggle::jsonToAssociativeArray($this->value);
            $value = $this->valueFromArray($array, $member);
            return $value;

        } elseif (Type::is($this, ESObject::class)) {
            $member = Type::sanitizeType($member, ESString::class)->unfold();
            $array = PhpTypeJuggle::objectToAssociativeArray($this->value);
            $value = $this->valueFromArray($array, $member);
            return $value;

        } elseif (Type::is($this, ESString::class)) {
            $array = PhpTypeJuggle::stringToIndexedArray($this->value);
            if (isset($array[$member])) {
                $value = $array[$member];
                return Shoop::string($value);
            }
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

// - PHP interfaces and magic methods
    public function __toString()
    {
        return $this->string()->unfold();
    }

    public function offsetExists($offset): bool
    {
        $bool = false;
        if (Type::is($this, ESArray::class)) {
            $bool = isset($this->value[$offset]);

        } elseif (Type::is($this, ESBool::class)) {
            $bool = $this->value;

        } elseif (Type::is($this, ESDictionary::class)) {
            $bool = isset($this->value[$offset]);

        } elseif (Type::is($this, ESInt::class)) {
            $array = PhpTypeJuggle::intToIndexedArray($this->value);
            $bool = isset($array[$offset]);

        } elseif (Type::is($this, ESJson::class)) {
            $array = PhpTypeJuggle::jsonToAssociativeArray($this->value);
            $bool = isset($array[$offset]);

        } elseif (Type::is($this,  ESObject::class)) {
            $array = PhpTypeJuggle::objectToAssociativeArray($this->value);
            $bool = isset($array[$offset]);

        } elseif (Type::is($this, ESString::class)) {
            $array = PhpTypeJuggle::stringToIndexedArray($this->value);
            $bool = isset($array[$offset]);

        }
        return $bool;
    }

    public function offsetGet($offset)
    {
        $array = [];
        if (Type::is($this, ESArray::class, ESDictionary::class)) {
            $array = $this->value;

        } elseif (Type::is($this, ESBool::class)) {
            $array = PhpTypeJuggle::boolToAssociativeArray($this->value);

        } elseif (Type::is($this, ESInt::class)) {
            $array = PhpTypeJuggle::intToIndexedArray($this->value);

        } elseif (Type::is($this, ESJson::class)) {
            $array = PhpTypeJuggle::jsonToAssociativeArray($this->value);

        } elseif (Type::is($this, ESObject::class)) {
            $array = PhpTypeJuggle::objectToAssociativeArray($this->value);

        } elseif (Type::is($this, ESString::class)) {
            $array = PhpTypeJuggle::stringToIndexedArray($this->value);

        }

        if (isset($array[$offset])) {
            $value = $array[$offset];
            return $value;

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

    private $temp;

    /**
     * rewind() -> valid() -> current() -> key() -> next() -> valid()...repeat
     */
    public function rewind(): void
    {
        if (Type::is($this, ESArray::class)) {
            $this->temp = $this->value;

        } elseif (Type::is($this, ESBool::class)) {
            $this->temp = PhpTypeJuggle::boolToAssociativeArray($this->value);

        } elseif (Type::is($this, ESDictionary::class)) {
            $this->temp = $this->value;

        } elseif (Type::is($this, ESInt::class)) {
            $this->temp = PhpTypeJuggle::intToIndexedArray($this->value);

        } elseif (Type::is($this, ESJson::class)) {
            $this->temp = PhpTypeJuggle::jsonToAssociativeArray($this->value);

        } elseif (Type::is($this, ESObject::class)) {
            $this->temp = PhpTypeJuggle::objectToAssociativeArray($this->value);

        } elseif (Type::is($this, ESString::class)) {
            $this->temp = PhpTypeJuggle::stringToIndexedArray($this->value);

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
