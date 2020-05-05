<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Helpers\Type;
use Eightfold\Shoop\Helpers\PhpTypeJuggle;

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

trait DropImp
{
    public function drop(...$members)
    {
        if (Type::is($this, ESArray::class, ESDictionary::class, ESJson::class, ESObject::class)) {
            foreach ($members as $member) {
                $this->offsetUnset($member);
            }
            return $this;

        } elseif (Type::is($this, ESString::class)) {
            $array = PhpTypeJuggle::stringToIndexedArray($this->value);
            foreach ($members as $member) {
                if (array_key_exists($member, $array)) {
                    unset($array[$member]);
                }
            }
            $string = implode("", $array);
            return Shoop::string($string);
        }
    }

    public function dropFirst($length = 1)
    {
        $length = Type::sanitizeType($length, ESInt::class)->unfold();
        if (Type::is($this, ESArray::class, ESDictionary::class)) {
            $array = $this->value;
            $array = $this->indexedArrayAfterDropping($array, $length);
            return Shoop::array($array);

        } elseif (Type::is($this, ESJson::class)) {
            $json = $this->value;
            $object = json_decode($json);
            $array = (array) $object;
            $array = $this->indexedArrayAfterDropping($array, $length);
            $object = (object) $array;
            $json = json_encode($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->value;
            $array = (array) $object;
            $array = $this->indexedArrayAfterDropping($array, $length);
            $object = (object) $array;
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $array = PhpTypeJuggle::stringToIndexedArray($this->value);
            $array = $this->indexedArrayAfterDropping($array, $length);
            $string = implode("", $array);
            return Shoop::string($string);

        }
    }

    public function dropLast($length = 1)
    {
        $length = Type::sanitizeType($length, ESInt::class)->unfold();
        if (Type::is($this, ESArray::class, ESDictionary::class)) {
            $array = $this->value;
            $array = $this->indexedArrayAfterDropping($array, -$length);
            return Shoop::array($array);

        } elseif (Type::is($this, ESJson::class)) {
            $json = $this->value;
            $object = json_decode($json);
            $array = (array) $object;
            $array = $this->indexedArrayAfterDropping($array, -$length);
            $object = (object) $array;
            $json = json_encode($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->value;
            $array = (array) $object;
            $array = $this->indexedArrayAfterDropping($array, -$length);
            $object = (object) $array;
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $array = PhpTypeJuggle::stringToIndexedArray($this->value);
            $array = $this->indexedArrayAfterDropping($array, -$length);
            $string = implode("", $array);
            return Shoop::string($string);

        }
    }

    public function noEmpties()
    {
        if (Type::is($this, ESArray::class, ESDictionary::class)) {
            $array = $this->value;
            $array = $this->indexedArrayAfterDroppingEmpties($array);
            return Shoop::array($array);

        } elseif (Type::is($this, ESJson::class)) {
            $json = $this->value;
            $object = json_decode($json);
            $array = (array) $object;
            $array = $this->indexedArrayAfterDroppingEmpties($array);
            $object = (object) $array;
            $json = json_encode($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->value;
            $array = (array) $object;
            $array = $this->indexedArrayAfterDroppingEmpties($array);
            $object = (object) $array;
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $array = PhpTypeJuggle::stringToIndexedArray($this->value);
            $array = $this->indexedArrayAfterDroppingEmpties($array);
            $string = implode("", $array);
            $string = preg_replace('/\s/', '', $string);
            return Shoop::string($string);

        }
    }

    private function indexedArrayAfterDropping(array $array, int $length): array
    {
        if ($length >= 0) {
            // first
            array_splice($array, 0, $length);

        } else {
            // last
            array_splice($array, $length);

        }
        return $array;
    }

    private function indexedArrayAfterDroppingEmpties(array $array): array
    {
        return array_filter($array);
    }
}
