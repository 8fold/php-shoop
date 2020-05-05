<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\Type;

class PhpTypeJuggle
{
    static public function indexedArrayToBool(array $array = []): bool
    {
        return self::arrayToInt($array) > 0;
    }

    static public function indexedArrayToAssociativeArray(array $array = []): array
    {
        $build = [];
        foreach ($array as $key => $value) {
            $key = "i". $key;
            $build[$key] = $value;
        }
        return $build;
    }

    static public function indexedArrayToInt(array $array = []): int
    {
        return self::arrayToInt($array);
    }

    static public function indexedArrayToJson(array $array = []): string
    {
        // TODO: Move to indexedArrayToObject()
        $object = PhpTypeJuggle::indexedArrayToObject($array);
        $json = json_encode($object);
        return $json;
    }

    static public function indexedArrayToObject(array $array = []): object
    {
        $associativeArray = PhpTypeJuggle::indexedArrayToAssociativeArray($array);
        $object = (object) $associativeArray;
        return $object;
    }

    static public function indexedArrayToString(array $array = []): string
    {
        return self::arrayToString($array);
    }

// -> Bool
    static public function boolToIndexedArray(bool $bool = true): array
    {
        return [$bool];
    }

    static public function boolToAssociativeArray(bool $bool = true): array
    {
        return ($bool === true)
            ? ["true" => true, "false" => false]
            : ["true" => false, "false" => true];
    }

    static public function boolToInt(bool $bool = true): int
    {
        $int = $bool
            ? 1
            : 0;
        return $int;
    }

    static public function boolToJson(bool $bool = true): string
    {
        $object = self::boolToObject($bool);
        $json = self::objectToJson($object);
        return $json;
    }

    static public function boolToObject(bool $bool = true): object
    {
        $dictionary = self::boolToAssociativeArray($bool);
        $object = self::associativeArrayToObject($dictionary);
        return $object;
    }

    static public function boolToString(bool $bool = true): string
    {
        $bool = $bool ? "true" : "";
        return $bool;
    }

// -> Associative Array (Dictionary)
    static public function associativeArrayToIndexedArray(array $array = []): array
    {
        return array_values($array);
    }

    static public function associativeArrayToBool(array $array = []): bool
    {
        return self::arrayToInt() > 0;
    }

    static public function associativeArrayToInt(array $array = []): int
    {
        return self::arrayToInt($array);
    }

    static public function associativeArrayToJson(array $array = []): string
    {
        $object = self::associativeArrayToObject($array);
        $json = self::objectToJson($object);
        return $json;
    }

    static public function associativeArrayToObject(array $array = []): object
    {
        $object = (object) $array;
        return $object;
    }

    static public function associativeArrayToString(array $array = []): string
    {
        $string = self::arrayToString($array);
        return str_replace("Array(", "Dictionary(", $string);
    }

// -> Int
    static public function intToIndexedArray(int $int, int $start = 0): array
    {
        return ($start > $int)
            ? range($int, $start)
            : range($start, $int);
    }

    static public function intToBool(int $int): bool
    {
        $bool = (bool) $int;
        return $bool;
    }

    static public function intToAssociativeArray(int $int): array
    {
        $array = self::intToIndexedArray($int);
        $array = self::indexedArrayToAssociativeArray($array);
        return $array;
    }

    static public function intToJson(int $int): string
    {
        $object = self::intToObject($int);
        $json = self::objectToJson($object);
        return $json;
    }

    static public function intToObject(int $int): object
    {
        $array = self::intToAssociativeArray($int);
        $object = self::associativeArrayToObject($array);
        return $object;
    }

    static public function intToString(int $int): string
    {
        $string = (string) $int;
        return $string;
    }

// -> Json
    static public function jsonToIndexedArray(string $json): array
    {
        self::checkIsJson($json);
        $object = self::jsonToObject($json);
        $array = self::objectToIndexedArray($object);
        return $array;
    }

    static public function jsonToBool(string $json): bool
    {
        self::checkIsJson($json);
        $object = self::jsonToObject($json);
        $bool = self::objectToBool($object);
        return $bool;
    }

    static public function jsonToAssociativeArray(string $json): array
    {
        self::checkIsJson($json);
        $object = self::jsonToObject($json);
        $array = self::objectToAssociativeArray($object);
        return $array;
    }

    static public function jsonToInt(string $json): int
    {
        self::checkIsJson($json);
        $object = self::jsonToObject($json);
        $int = self::objectToInt($object);
        return $int;
    }

    static public function jsonToObject(string $json): object
    {
        $object = json_decode($json);
        return $object;
    }

    static public function checkIsJson(string $json): void
    {
        if (Type::isNotJson($json)) {
            trigger_error("The given string does not appear to be valid JSON.", E_USER_ERROR);
        }
    }

// -> Object
    static public function objectToIndexedArray(object $object): array
    {
        $array = (array) $object;
        $array = array_values($array);
        return $array;
    }

    static public function objectToBool(object $object): bool
    {
        $array = self::objectToAssociativeArray($object);
        $bool = self::indexedArrayToBool($array);
        return $bool;
    }

    static public function objectToAssociativeArray(object $object): array
    {
        $array = (array) $object;
        return $array;
    }

    static public function objectToInt(object $object): int
    {
        $array = self::objectToIndexedArray($object);
        $int = self::arrayToInt($array);
        return $int;
    }

    static public function objectToJson(object $object): string
    {
        return json_encode($object);
    }

    static public function objectToString(object $object): string
    {
        $array = self::objectToAssociativeArray($object);
        $string = self::associativeArrayToString($array);
        $string = str_replace("Dictionary(", "stdClass Object(", $string);
        return $string;
    }

// -> String
    static public function stringToIndexedArray(string $string): array
    {
        return preg_split('//u', $string, null, PREG_SPLIT_NO_EMPTY);
    }

    static public function stringToBool(string $string): bool
    {
        $bool = empty($string);
        $bool = ! $bool;
        return $bool;
    }

    static public function stringToAssociativeArray(string $string): array
    {
        $array = self::stringToIndexedArray($string);
        $dictionary = self::indexedArrayToAssociativeArray($array);
        return $dictionary;
    }

    static public function stringToInt(string $string): int
    {
        $int = intval($string);
        return $int;
    }

    static public function stringToObject(string $string): object
    {
        $object = new \stdClass();
        $object->string = $string;
        return $object;
    }

// -> Generic
    static public function arrayToInt(array $array = []): int
    {
        return count($array);
    }

    static public function arrayToString(array $array = []): string
    {
        $printed = print_r($array, true);
        $oneLine = preg_replace('/\s+/', ' ', $printed);
        $commas = str_replace(
            [" [", " ) ", " (, "],
            [", [", ")", "("],
            $oneLine);
        $fixSpacingWhenEmpty = preg_replace('/\s+\(/', "(", $commas, 1);
        return trim($fixSpacingWhenEmpty);
    }
}
