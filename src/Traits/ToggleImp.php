<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Helpers\Type;

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

trait ToggleImp
{
    public function toggle($preserveMembers = true) // 7.4 : self
    {
        if (Type::is($this, ESArray::class)) {
            $array = $this->value;
            $array = $this->arrayReversed($array, $preserveMembers);
            return Shoop::array($array);

        } elseif (Type::is($this, ESBool::class)) {
            $bool = $this->value;
            $bool = ! $bool;
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESDictionary::class)) {
            $dictionary = $this->value;
            $dictionary = $this->arrayReversed($dictionary, $preserveMembers);
            return Shoop::dictionary($dictionary);

        } elseif (Type::is($this, ESInt::class)) {
            $int = $this->value;
            $int = -1 * $int;
            return Shoop::int($int);

        } elseif (Type::is($this, ESJson::class)) {
            $json = $this->value;
            $object = json_decode($json);
            $dictionary = (array) $object;
            $dictionary = $this->arrayReversed($dictionary, $preserveMembers);
            $object = (object) $dictionary;
            $json = json_encode($object);
            return Shoop::json($json);

        }
    }

    private function arrayReversed(array $array, bool $preserveMembers): array
    {
        return ($preserveMembers)
            ? array_reverse($array, true)
            : array_reverse($array);
    }
}
