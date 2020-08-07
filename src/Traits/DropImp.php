<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpIndexedArray,
    PhpAssociativeArray
};

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
            $array = $this->arrayUnfolded();
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
        if (Type::is($this, ESArray::class)) {
            $array = $this->arrayUnfolded();
            $array = PhpIndexedArray::afterDropping($array, $length);
            return Shoop::array($array);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->dictionaryUnfolded();
            $array = PhpAssociativeArray::afterDropping($array, $length);
            return Shoop::dictionary($array);

        } elseif (Type::is($this, ESJson::class)) {
            $array = $this->dictionaryUnfolded();
            $array = PhpAssociativeArray::afterDropping($array, $length);
            $json = PhpAssociativeArray::toJson($array);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $array = $this->dictionaryUnfolded();
            $array = PhpAssociativeArray::afterDropping($array, $length);
            $object = PhpAssociativeArray::toObject($array);
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $array = $this->arrayUnfolded();
            $array = PhpAssociativeArray::afterDropping($array, $length);
            $string = implode("", $array);
            return Shoop::string($string);

        }
    }

    public function dropLast($length = 1)
    {
        $length = Type::sanitizeType($length, ESInt::class)->unfold();
        if (Type::is($this, ESArray::class)) {
            $array = $this->main();
            $array = PhpIndexedArray::afterDropping($array, -$length);
            return Shoop::array($array);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->dictionaryUnfolded();
            $array = PhpAssociativeArray::afterDropping($array, -$length);
            return Shoop::dictionary($array);

        } elseif (Type::is($this, ESJson::class)) {
            $array = $this->dictionaryUnfolded();
            $array = PhpAssociativeArray::afterDropping($array, -$length);
            $json = PhpAssociativeArray::toJson($array);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $array = $this->dictionaryUnfolded();
            $array = PhpAssociativeArray::afterDropping($array, -$length);
            $object = PhpAssociativeArray::toObject($array);
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $array = $this->arrayUnfolded();
            $array = PhpIndexedArray::afterDropping($array, -$length);
            $string = implode("", $array);
            return Shoop::string($string);

        }
    }

    public function noEmpties()
    {
        if (Type::is($this, ESArray::class)) {
            $array = $this->arrayUnfolded();
            $array = PhpIndexedArray::afterDroppingEmpties($array);
            return Shoop::array($array);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->dictionaryUnfolded();
            $array = PhpAssociativeArray::afterDroppingEmpties($array);
            return Shoop::dictionary($array);

        } elseif (Type::is($this, ESJson::class)) {
            $array = $this->dictionaryUnfolded();
            $array = PhpAssociativeArray::afterDroppingEmpties($array);
            $json = PhpAssociativeArray::toJson($array);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $array = $this->dictionaryUnfolded();
            $array = PhpAssociativeArray::afterDroppingEmpties($array);
            $object = PhpAssociativeArray::toObject($array);
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $array = $this->arrayUnfolded();
            $array = PhpIndexedArray::afterDroppingEmpties($array);
            $string = implode("", $array);
            $string = preg_replace('/\s/', '', $string);
            return Shoop::string($string);

        }
    }
}
