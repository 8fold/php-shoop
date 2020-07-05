<?php

namespace Eightfold\Shoop\Traits\ShoopedImpExtensions;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpIndexedArray,
    PhpBool,
    PhpInt,
    PhpJson,
    PhpObject,
    PhpString
};

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

trait PhpInterfacesImp
{
// - Countable
    public function count()
    {
        $int = $this->int();
        if (Type::is($this, ESString::class)) {
            $int = strlen($this->value);
        }
        return Shoop::int($int);
    }

// - ArrayAccess
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

// - Iterator
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
