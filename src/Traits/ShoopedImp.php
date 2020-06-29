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
    ESString,
    ESYaml
};

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Helpers\{
    Type,
    PhpIndexedArray,
    PhpBool,
    PhpAssociativeArray,
    PhpInt,
    PhpJson,
    PhpObject,
    PhpString,
    SymfonyYaml
};

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
        $instanceClass = get_class($this); // TODO: PHP 8 allows for $instance::class
        $value = $instanceClass::to($this, $className);
        return $className::fold($value);
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

    public function is($compare, \Closure $closure = null)
    {
        if (Type::isNotShooped($compare)) {
            $compare = Type::sanitizeType($compare, static::class);
        }
        $bool = $this->unfold() === $compare->unfold();
        return $this->condition($bool, $closure);
    }

    public function isNot($compare, \Closure $closure = null)
    {
        $bool = $this->is($compare)->toggle();
        return $this->condition($bool, $closure);
    }

    public function isEmpty(\Closure $closure = null)
    {
        $bool = Type::isEmpty($this);
        return $this->condition($bool, $closure);
    }

    public function isNotEmpty(\Closure $closure = null)
    {
        $bool = $this->isEmpty()->not();
        return $this->condition($bool, $closure);
    }

    public function value()
    {
        return $this->value;
    }

    public function get($member = 0)
    {
        if (Type::is($this, ESArray::class, ESInt::class, ESString::class)) {
            $member = Type::sanitizeType($member, ESInt::class)->unfold();

        } elseif (Type::is($this, ESDictionary::class, ESJson::class, ESObject::class, ESYaml::class)) {
            $member = Type::sanitizeType($member, ESString::class)->unfold();

        }

        $array = Shoop::array([]);
        if (Type::is($this, ESArray::class, ESDictionary::class) and $this->offsetExists($member)) {
            return Shoop::this($this->offsetGet($member)); // The only return of consequence

        } elseif (Type::is($this, ESBool::class)) {
            $array = $this->dictionary();

        } elseif (Type::is($this, ESInt::class)) {
            $array = PhpInt::toIndexedArray($this->value);

        } elseif (Type::is($this, ESJson::class)) {
            $array = PhpJson::toAssociativeArray($this->value);

        } elseif (Type::is($this, ESObject::class)) {
            $array = PhpObject::toAssociativeArray($this->value);

        } elseif (Type::is($this, ESString::class)) {
            $array = PhpString::toIndexedArray($this->value);

        } elseif (Type::is($this, ESYaml::class)) {
            $array = SymfonyYaml::toAssociativeArray($this->value);

        }
        return Shoop::this($array)->get($member);
    }

    public function getUnfolded($name)
    {
        $value = $this->get($name);
        return (Type::isShooped($value)) ? $value->unfold() : $value;
    }

    public function set($value, $member = null, $overwrite = true)
    {
        if (Type::is($this, ESArray::class, ESDictionary::class)) {
            $array = $this->value;
            $array = (Type::is($this, ESArray::class))
                ? PhpIndexedArray::afterSettingValue($array, $value, $member, $overwrite)
                : PhpAssociativeArray::afterSettingValue($array, $value, $member, $overwrite);
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
            $array = PhpJson::toAssociativeArray($json);
            $array = PhpAssociativeArray::afterSettingValue($array, $value, $member, $overwrite);
            $json = PhpAssociativeArray::toJson($array);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->value;
            $array = PhpObject::toAssociativeArray($object);
            $array = PhpAssociativeArray::afterSettingValue($array, $value, $member, $overwrite);
            $object = PhpAssociativeArray::toObject($array);
            return Shoop::object($object);
        }
    }

    private function condition($bool, \Closure $closure = null)
    {
        $value = $this->value();
        if ($closure === null) {
            $closure = function($bool, $value) {
                return Shoop::this($bool);
            };
        }
        return $closure($bool, Shoop::this($value));
    }

// - __call helpers
    private function isGetter(string $name): bool
    {
        return PhpString::startsAndEndsWith($name, "get", "Unfolded") or
            PhpString::startsWithGet($name) or
            (! method_exists($this, $name) and ! PhpString::startsWithGet($name));
    }

    private function needsUnfolding($name)
    {
        return PhpString::startsAndEndsWith($name, "get", "Unfolded") or
            PhpString::endsWithUnfolded($name);
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
        $remove = [];
        if (PhpString::startsAndEndsWith($name, "get", "Unfolded")) {
            $remove = ["get", "Unfolded"];

        } elseif (PhpString::startsWithSet($name)) {
            $remove = ["set"];

        } elseif (PhpString::startsWithGet($name)) {
            $remove = ["get"];

        } elseif (PhpString::endsWithUnfolded($name)) {
            $remove = ["Unfolded"];

        }

        $cName = $name;
        if (count($remove) > 0) {
            $cName = PhpString::afterRemoving($name, $remove);
            $cName = lcfirst($cName);
        }

        $value;
        if (PhpString::startsWithSet($name)) {
            $value = (isset($args[0])) ? $args[0] : null;
            $overwrite = (isset($args[1])) ? $args[1] : true;
            $value = $this->set($value, $cName, $overwrite);

        } elseif ($this->isGetter($name) and method_exists($this, $cName)) {
            $value = $this->{$cName}(...$args);

        } elseif ($this->offsetExists($cName)) {
            $value = $this->get($cName);

        } elseif ($this->isGetter($name)) {
            $value = Shoop::this($this->{$cName});

        }

        return (Type::isShooped($value) and $this->needsUnfolding($name))
            ? $value->unfold()
            : $value;
    }

    public function __get($name)
    {
        $value = null;
        if ($this->offsetExists($name)) {
            $value = $this->offsetGet($name);

        } elseif (method_exists($this, $name)) {
            $value = $this->{$name}();

        }
        return (Type::isShooped($value)) ? $value->unfold() : $value;
    }

// -> ArrayAccess
    public function offsetExists($offset): bool
    {
        $bool = false;
        if (Type::is($this, ESArray::class)) {
            $bool = isset($this->value[$offset]);
            if (! $bool) {
                $array = PhpIndexedArray::toAssociativeArray($this->value);
                $bool = isset($array[$offset]);

            }

        } elseif (Type::is($this, ESBool::class)) {
            $array = PhpBool::toAssociativeArray($this->value);
            $bool = isset($array[$offset]);

        } elseif (Type::is($this, ESDictionary::class)) {
            $bool = isset($this->value[$offset]);

        } elseif (Type::is($this, ESInt::class)) {
            $array = PhpInt::toIndexedArray($this->value);
            $bool = isset($array[$offset]);
            if (! $bool) {
                $array = PhpInt::toAssociativeArray($this->value);
                $bool = isset($array[$offset]);
            }

        } elseif (Type::is($this, ESJson::class)) {
            $array = PhpJson::toAssociativeArray($this->value);
            $bool = isset($array[$offset]);

        } elseif (Type::is($this,  ESObject::class)) {
            $array = PhpObject::toAssociativeArray($this->value);
            $bool = isset($array[$offset]);

        } elseif (Type::is($this, ESString::class)) {
            $array = PhpString::toIndexedArray($this->value);
            $bool = isset($array[$offset]);
            if (! $bool) {
                $array = PhpIndexedArray::toAssociativeArray($array);
                $bool = isset($array[$offset]);
            }

        } elseif (Type::is($this, ESYaml::class)) {
            $array = SymfonyYaml::toAssociativeArray($this->value);
            $bool = isset($array[$offset]);

        }
        return $bool;
    }

    public function offsetGet($offset)
    {
        $array = [];
        if (Type::is($this, ESArray::class)) {
            $array = $this->value;
            if (is_string($offset)) {
                $array = PhpIndexedArray::toAssociativeArray($array);
            }

        } elseif (Type::is($this, ESBool::class)) {
            $array = PhpBool::toAssociativeArray($this->value);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->value;

        } elseif (Type::is($this, ESInt::class)) {
            $array = PhpInt::toIndexedArray($this->value);
            if (is_string($offset)) {
                $array = PhpInt::toAssociativeArray($this->value);
            }

        } elseif (Type::is($this, ESJson::class)) {
            $array = PhpJson::toAssociativeArray($this->value);

        } elseif (Type::is($this, ESObject::class)) {
            $array = PhpObject::toAssociativeArray($this->value);

        } elseif (Type::is($this, ESString::class)) {
            $array = PhpString::toIndexedArray($this->value);
            if (is_string($offset)) {
                $array = PhpIndexedArray::toAssociativeArray($array);
            }
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
            $this->temp = PhpBool::toAssociativeArray($this->value);

        } elseif (Type::is($this, ESDictionary::class)) {
            $this->temp = $this->value;

        } elseif (Type::is($this, ESInt::class)) {
            $this->temp = PhpInt::toIndexedArray($this->value);

        } elseif (Type::is($this, ESJson::class)) {
            $this->temp = PhpJson::toAssociativeArray($this->value);

        } elseif (Type::is($this, ESObject::class)) {
            $this->temp = PhpObject::toAssociativeArray($this->value);

        } elseif (Type::is($this, ESString::class)) {
            $this->temp = PhpString::toIndexedArray($this->value);

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
