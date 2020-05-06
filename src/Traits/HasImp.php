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
        $m = Type::sanitizeType($member, ESInt::class)->unfold();
        $array = $this->arrayUnfolded();
        if (Type::is($this, ESDictionary::class, ESJson::class, ESObject::class)) {
            $m = Type::sanitizeType($member, ESString::class)->unfold();
            $array = $this->dictionaryUnfolded();

        }
        $bool = $this->arrayHasMember($array, $m);
        return Shoop::bool($bool);
    }

    public function arrayHasMember(array $array, $member): bool
    {
        $bool = array_key_exists($member, $array);
        return $bool;
    }
}
