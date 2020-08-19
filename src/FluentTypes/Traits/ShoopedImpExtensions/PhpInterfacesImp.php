<?php

namespace Eightfold\Shoop\Traits\ShoopedImpExtensions;

use \stdClass;

use Eightfold\Shoop\FluentTypes\Helpers\{

    PhpIndexedArray,
    PhpBool,
    PhpInt,
    PhpJson,
    PhpObject,
    PhpString
};

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\FluentTypes\{
    ESArray,
    ESBoolean,
    ESDictionary,
    ESInteger,
    ESJson,
    ESObject,
    ESString
};

trait PhpInterfacesImp
{
// - Countable
    public function count(): ESInteger
    {
        $int = $this->int();
        return Shoop::int($int);
    }

// - ArrayAccess
    public function offsetExists($offset): bool
    {
        $bool = false;
        if (Type::is($this, ESArray::class)) {
            $bool = isset($this->main[$offset]);
            if (! $bool) {
                $array = PhpIndexedArray::toAssociativeArray($this->main());
                $bool = isset($array[$offset]);
            }

        } elseif (Type::is($this, ESBoolean::class)) {
            $array = PhpBool::toAssociativeArray($this->main());
            $bool = isset($array[$offset]);

        } elseif (Type::is($this, ESDictionary::class)) {
            $bool = isset($this->main[$offset]);

        } elseif (Type::is($this, ESInteger::class)) {
            $array = PhpInt::toIndexedArray($this->main());
            $bool = isset($array[$offset]);
            if (! $bool) {
                $array = PhpInt::toAssociativeArray($this->main());
                $bool = isset($array[$offset]);
            }

        } elseif (Type::is($this, ESJson::class)) {
            $array = PhpJson::toAssociativeArray($this->main());
            $bool = isset($array[$offset]);

        } elseif (Type::is($this,  ESObject::class)) {
            $array = PhpObject::toAssociativeArray($this->main());
            $bool = isset($array[$offset]);

        } elseif (Type::is($this, ESString::class)) {
            // $array = PhpString::toIndexedArray($this->main());
            // $bool = isset($array[$offset]);
            // if (! $bool) {
            //     $array = PhpIndexedArray::toAssociativeArray($array);
            //     $bool = isset($array[$offset]);

            // }
        }
        return $bool;
    }

    public function offsetGet($offset)
    {
        $array = [];
        if (Type::is($this, ESArray::class)) {
            $array = $this->main();
            if (is_string($offset)) {
                $array = PhpIndexedArray::toAssociativeArray($array);
            }

        } elseif (Type::is($this, ESBoolean::class)) {
            $array = PhpBool::toAssociativeArray($this->main());

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->main();

        } elseif (Type::is($this, ESInteger::class)) {
            $array = PhpInt::toIndexedArray($this->main());
            if (is_string($offset)) {
                $array = PhpInt::toAssociativeArray($this->main());
            }

        } elseif (Type::is($this, ESJson::class)) {
            $array = PhpJson::toAssociativeArray($this->main());

        } elseif (Type::is($this, ESObject::class)) {
            $array = PhpObject::toAssociativeArray($this->main());

        } elseif (Type::is($this, ESString::class)) {
            // $array = PhpString::toIndexedArray($this->main());
            // if (is_string($offset)) {
            //     $array = PhpIndexedArray::toAssociativeArray($array);
            // }
        }

        if (isset($array[$offset])) {
            $value = $array[$offset];
            return $value;

        }
        trigger_error("Undefined offset: {$offset}", E_USER_ERROR);
    }

    public function offsetSet($offset, $value): void
    {
        if (Type::is($this, ESInteger::class, ESBoolean::class)) {
            $this->main = $value;

        } elseif (Type::is($this, ESJson::class)) {
            $object = json_decode($this->main());
            $object->{$offset} = $value;
            $this->main = json_encode($object);

        } elseif (Type::is($this, ESObject::class)) {
            $this->main->{$offset} = $value;

        } else {
            // $this->main[$offset] = $value;

        }
    }

    public function offsetUnset($offset): void
    {
        if (Type::is($this, ESString::class)) {
            $array = $this->array();
            $array->offsetUnset($offset);
            $this->main = join("", $array->unfold());

        } elseif (Type::is($this, ESObject::class)) {
            unset($this->main->{$offset});

        } elseif (Type::is($this, ESJson::class)) {
            $object = json_decode($this->main());
            unset($object->{$offset});
            $this->main = json_encode($object);

        } else {
            // unset($this->main[$offset]);

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
            $this->temp = $this->main();

        } elseif (Type::is($this, ESBoolean::class)) {
            $this->temp = PhpBool::toAssociativeArray($this->main());

        } elseif (Type::is($this, ESDictionary::class)) {
            $this->temp = $this->main();

        } elseif (Type::is($this, ESInteger::class)) {
            $this->temp = PhpInt::toIndexedArray($this->main());

        } elseif (Type::is($this, ESJson::class)) {
            $this->temp = PhpJson::toAssociativeArray($this->main());

        } elseif (Type::is($this, ESObject::class)) {
            $this->temp = PhpObject::toAssociativeArray($this->main());

        } elseif (Type::is($this, ESString::class)) {
            // $this->temp = PhpString::toIndexedArray($this->main());

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
            return Type::sanitizeType($member, ESInteger::class, "int")->unfold();
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

// - JsonSerializable
    public function jsonSerialize(): stdClass
    {
        return $this->object()->unfold();
    }
}
