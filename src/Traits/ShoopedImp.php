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
            foreach ($array as $member => $value) {
                if (Type::isShooped($value)) {
                    $value = $value->unfold();
                }
                $return[$member] = $value;
            }
        }
        return $return;
    }

    private function juggleTo(string $className)
    {
        return PhpTypeJuggle::juggleTo($this, $className);
    }

    public function array(): ESArray
    {
        return $this->juggleTo(ESArray::class);
    }

    public function bool(): ESBool
    {
        return $this->juggleTo(ESBool::class);
    }

    public function dictionary(): ESDictionary
    {
        return $this->juggleTo(ESDictionary::class);
    }

    public function int(): ESInt
    {
        return $this->juggleTo(ESInt::class);
    }

    public function json(): ESJson
    {
        return $this->juggleTo(ESJson::class);
    }

    public function object(): ESObject
    {
        return $this->juggleTo(ESObject::class);
    }

    public function string(): ESString
    {
        return $this->juggleTo(ESString::class);
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
        $bool = Type::isEmpty($this);
        return Shoop::bool($bool);
    }

    public function isNotEmpty(): ESBool
    {
        return $this->isEmpty()->toggle();
    }

    public function value()
    {
        return $this->value;
    }

    public function get($member = 0)
    {
        if (Type::is($this, ESArray::class)) {
            $member = Type::sanitizeType($member, ESInt::class)->unfold();
            $array = $this->value;
            $value = $this->valueFromArray($array, $member);
            return $value;

        } elseif (Type::is($this, ESBool::class)) {
            if (is_string($member) && ($member === "true" || $member === "false")) {
                $bool = $this->dictionary()->{$member};

            } else {
                $bool = $this->value;

            }
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

    private function handleSet($name, $args)
    {
        $name = lcfirst(str_replace("set", "", $name));
        $overwrite = (isset($args[1])) ? $args[1] : true;
        $value = (isset($args[0])) ? $args[0] : null;

        return $this->set($value, $name, $overwrite);
    }

    public function getUnfolded($name)
    {
        $value = $this->get($name);
        return (Type::isShooped($value)) ? $value->unfold() : $value;
    }

    private function valueFromArray(array $array, $member)
    {
        if (! $this->offsetExists($member)) {
            trigger_error("Undefined index or member.");
        }

        $value = $this[$member];
        return Type::sanitizeType($value);
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

    private function startsWithSet(string $name): bool
    {
        return substr($name, 0, strlen("set")) === "set";
    }

    private function startsWithGet(string $name): bool
    {
        return substr($name, 0, strlen("get")) === "get";
    }

    private function endsWithUnfolded(string $name): bool
    {
        return substr($name, -(strlen("Unfolded"))) === "Unfolded";
    }

    private function isGetWildcardUnfolded(string $name): bool
    {
        return $this->startsWithGet($name) and $this->endsWithUnfolded($name);
    }

    private function convertCallName(string $name): string
    {
        if ($this->isGetWildcardUnfolded($name)) {
            $name = str_replace(["get", "Unfolded"], "", $name);
            return lcfirst($name);

        } elseif ($this->startsWithSet($name)) {
            return lcfirst(str_replace("set", "", $name));

        } elseif ($this->startsWithGet($name)) {
            return lcfirst(str_replace("get", "", $name));

        } elseif ($this->endsWithUnfolded($name)) {
            return str_replace("Unfolded", "", $name);

        } elseif (is_callable([$this, "get"])) {
            return $name;

        }
        return $name;
    }

    private function isGetter(string $name): bool
    {
        return $this->isGetWildcardUnfolded($name) or $this->startsWithGet($name) or
            (! method_exists($this, $name) and ! $this->startsWithGet($name));
    }

    private function isSetter(string $name): bool
    {
        return $this->startsWithSet($name);
    }

    private function needsUnfolding($name)
    {
        return $this->isGetWildcardUnfolded($name) or $this->endsWithUnfolded($name);
    }

// - PHP interfaces and magic methods
    public function __toString(): string
    {
        return $this->string()->unfold();
    }

    public function __debugInfo()
    {
        return [
            "value" => $this->value
        ];
    }

    public function __call(string $name, array $args = [])
    {
        $cName = $this->convertCallName($name);
        $value;
        if ($this->isSetter($name)) {
            $value = $this->handleSet($cName, $args);

        } elseif ($this->isGetter($name) and method_exists($this, $cName)) {
            $value = $this->{$cName}();

        } elseif ($this->isGetter($name)) {
            $value = Shoop::this($this->{$cName});

        }

        if (Type::isShooped($value) and $this->needsUnfolding($name)) {
            $value = $value->unfold();

        }
        return $value;
    }

    public function __get($name)
    {
        if ($this->offsetExists($name)) {
            $value = $this->offsetGet($name);
            return (Type::isShooped($value)) ? $value->unfold() : $value;
        }
        return null;
    }

// -> ArrayAccess
    public function offsetExists($offset): bool
    {
        $bool = false;
        if (Type::is($this, ESArray::class)) {
            $bool = isset($this->value[$offset]);

        } elseif (Type::is($this, ESBool::class)) {
            $array = PhpTypeJuggle::boolToAssociativeArray($this->value);
            $bool = isset($array[$offset]);

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
        $member = key($temp);
        return $temp[$member];
    }

    public function key()
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        $temp = $this->temp;
        $member = key($temp);
        if (is_int($member)) {
            return Type::sanitizeType($member, ESInt::class, "int")->unfold();
        }
        return Type::sanitizeType($member, ESString::class, "string")->unfold();
    }

    public function next(): void
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        next($this->temp);
    }
}
