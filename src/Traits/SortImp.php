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

trait SortImp
{
    public function sort($asc = true, $caseSensitive = true)
    {
        if (Type::is($this, ESArray::class)) {
            $array = $this->arrayUnfolded();
            $array = $this->indexedArrayToSortedIndexedArray($array, $asc, $caseSensitive);
            return Shoop::array($array);

        } elseif (Type::is($this, ESDictionary::class)) {
            $array = $this->dictionaryUnfolded();
            $dictionary = $this->associativeArrayToSortedAssociativeArray($array, $asc, $caseSensitive);
            return Shoop::dictionary($dictionary);

        } elseif (Type::is($this, ESJson::class)) {
            $object = $this->objectUnfolded();
            $object = $this->objectToSortedObject($object, $asc, $caseSensitive);
            $json = PhpTypeJuggle::objectToJson($object);
            return Shoop::json($json);

        } elseif (Type::is($this, ESObject::class)) {
            $object = $this->objectUnfolded();
            $object = $this->objectToSortedObject($object, $asc, $caseSensitive);
            return Shoop::object($object);

        } elseif (Type::is($this, ESString::class)) {
            $array = $this->arrayUnfolded();
            $array = $this->indexedArrayToSortedIndexedArray($array, $asc, $caseSensitive);
            $string = implode("", $array);
            return Shoop::string($string);

        }
    }

    private function indexedArrayToSortedIndexedArray(
        array $array,
        bool $asc,
        bool $caseSensitive
    ): array
    {
        if ($asc) {
            if ($caseSensitive) {
                sort($array, SORT_NATURAL);

            } else {
                sort($array, SORT_NATURAL | SORT_FLAG_CASE);

            }

        } else {
            if ($caseSensitive) {
                rsort($array, SORT_NATURAL);

            } else {
                rsort($array, SORT_NATURAL | SORT_FLAG_CASE);

            }
        }
        return $array;
    }

    private function associativeArrayToSortedAssociativeArray(
        array $dictionary,
        bool $asc,
        bool $caseSensitive
    ): array
    {
        if ($asc) {
            if ($caseSensitive) {
                asort($dictionary, SORT_NATURAL);

            } else {
                asort($dictionary, SORT_NATURAL | SORT_FLAG_CASE);

            }

        } else {
            if ($caseSensitive) {
                arsort($dictionary, SORT_NATURAL);

            } else {
                arsort($dictionary, SORT_NATURAL | SORT_FLAG_CASE);

            }
        }
        return $dictionary;
    }

    private function objectToSortedObject(
        object $object,
        bool $asc,
        bool $caseSensitive
    ): object
    {
        $dictionary = (array) $object;
        $dictionary = $this->associativeArrayToSortedAssociativeArray($dictionary, $asc, $caseSensitive);
        $object = (object) $dictionary;
        return $object;
    }
}
