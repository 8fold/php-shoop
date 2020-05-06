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
            $array = $this->arrayAfterDropping($array, $length);
            return Shoop::array($array);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->dictionaryUnfolded();
            $array = $this->arrayAfterDropping($array, $length);
            return Shoop::dictionary($array);

        } elseif (Type::is($this, ESJson::class)) {
            $array = $this->dictionaryUnfolded();
            $array = $this->arrayAfterDropping($array, $length);
            $json = PhpTypeJuggle::associativeArrayToJson($array);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $array = $this->dictionaryUnfolded();
            $array = $this->arrayAfterDropping($array, $length);
            $object = PhpTypeJuggle::associativeArrayToObject($array);
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $array = $this->arrayUnfolded();
            $array = $this->arrayAfterDropping($array, $length);
            $string = implode("", $array);
            return Shoop::string($string);

        }
    }

    public function dropLast($length = 1)
    {
        $length = Type::sanitizeType($length, ESInt::class)->unfold();
        if (Type::is($this, ESArray::class)) {
            $array = $this->value;
            $array = $this->arrayAfterDropping($array, -$length);
            return Shoop::array($array);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->dictionaryUnfolded();
            $array = $this->arrayAfterDropping($array, -$length);
            return Shoop::dictionary($array);

        } elseif (Type::is($this, ESJson::class)) {
            $array = $this->dictionaryUnfolded();
            $array = $this->arrayAfterDropping($array, -$length);
            $json = PhpTypeJuggle::associativeArrayToJson($array);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $array = $this->dictionaryUnfolded();
            $array = $this->arrayAfterDropping($array, -$length);
            $object = PhpTypeJuggle::associativeArrayToObject($array);
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $array = $this->dictionaryUnfolded();
            $array = $this->arrayAfterDropping($array, -$length);
            $string = implode("", $array);
            return Shoop::string($string);

        }
    }

    public function noEmpties()
    {
        if (Type::is($this, ESArray::class)) {
            $array = $this->arrayUnfolded();
            $array = $this->arrayAfterDroppingEmpties($array);
            return Shoop::array($array);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->dictionaryUnfolded();
            $array = $this->arrayAfterDroppingEmpties($array);
            return Shoop::dictionary($array);

        } elseif (Type::is($this, ESJson::class)) {
            $array = $this->dictionaryUnfolded();
            $array = $this->arrayAfterDroppingEmpties($array);
            $json = PhpTypeJuggle::associativeArrayToJson($array);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $array = $this->dictionaryUnfolded();
            $array = $this->arrayAfterDroppingEmpties($array);
            $object = PhpTypeJuggle::associativeArrayToObject($array);
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $array = $this->arrayUnfolded();
            $array = $this->arrayAfterDroppingEmpties($array);
            $string = implode("", $array);
            $string = preg_replace('/\s/', '', $string);
            return Shoop::string($string);

        }
    }

    private function arrayAfterDropping(array $array, int $length): array
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

    private function arrayAfterDroppingEmpties(array $array): array
    {
        return array_filter($array);
    }
}
