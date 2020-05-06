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

trait ToggleImp
{
    public function toggle($preserveMembers = true)
    {
        if (Type::is($this, ESArray::class)) {
            $array = $this->arrayUnfolded();
            $array = $this->arrayReversed($array, $preserveMembers);
            return Shoop::array($array);

        } elseif (Type::is($this, ESBool::class)) {
            $bool = $this->boolUnfolded();
            $bool = ! $bool;
            return Shoop::bool($bool);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->dictionaryUnfolded();
            $dictionary = $this->arrayReversed($array, $preserveMembers);
            return Shoop::dictionary($dictionary);

        } elseif (Type::is($this, ESInt::class)) {
            $int = $this->intUnfolded();
            $int = -1 * $int;
            return Shoop::int($int);

        } elseif (Type::is($this, ESJson::class)) {
            $object = $this->objectUnfolded();
            $object = $this->objectReversed($object, $preserveMembers);
            $json = PhpTypeJuggle::objectToJson($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->objectUnfolded();
            $object = $this->objectReversed($object, $preserveMembers);
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $string = $this->stringUnfolded();
            $string = $this->stringReversed($string);
            return Shoop::string($string);
        }
    }

    // TODO: Make reversed on ESArray, ESDictionary
    private function arrayReversed(array $array, bool $preserveMembers): array
    {
        return ($preserveMembers)
            ? array_reverse($array, true)
            : array_reverse($array);
    }

    // TODO: Make reversed ESString
    private function stringReversed(string $string): string
    {
        $array = PhpTypeJuggle::stringToIndexedArray($string);
        $array = $this->arrayReversed($array, true);
        return implode("", $array);
    }

    // TODO: Make reversed on ESJson, ESObject
    private function objectReversed(object $object, bool $preserveMembers): object
    {
        $dictionary = (array) $object;
        $dictionary = $this->arrayReversed($dictionary, $preserveMembers);
        $object = (object) $dictionary;
        return $object;
    }
}
