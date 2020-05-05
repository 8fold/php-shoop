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

trait HasImp
{
    public function has($needle): ESBool
    {
        $array = $this->arrayUnfolded();
        $bool = in_array($needle, $array);
        return Shoop::bool($bool);
    }

    public function hasMember($member): ESBool
    {
        if (Type::is($this, ESArray::class)) {
            $member = Type::sanitizeType($member, ESInt::class)->unfold();
            $array = $this->value;
            $bool = $this->arrayHasMember($array, $member);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESDictionary::class)) {
            $member = Type::sanitizeType($member, ESString::class)->unfold();
            $array = $this->value;
            $bool = $this->arrayHasMember($array, $member);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESJson::class)) {
            $member = Type::sanitizeType($member, ESString::class)->unfold();
            $json = $this->value;
            $object = json_decode($json);
            $array = (array) $object;
            $bool = $this->arrayHasMember($array, $member);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->value;
            $array = (array) $object;
            $bool = $this->arrayHasMember($array, $member);
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESString::class)) {
            $array = PhpTypeJuggle::stringToIndexedArray($this->value);
            $bool = $this->arrayHasMember($array, $member);
            return Shoop::bool($bool);
        }
    }

    public function arrayHasMember(array $array, $member): bool
    {
        $bool = array_key_exists($member, $array);
        return $bool;
    }
}
