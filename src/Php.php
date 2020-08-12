<?php
declare(strict_types=1);

namespace Eightfold\Shoop;

use \stdClass;

use League\Pipeline\Pipeline;

use Eightfold\Shoop\Php\ToArrayFromString;

use Eightfold\Shoop\Php\DivideString;

use Eightfold\Shoop\Php\EndsWithString;

use Eightfold\Shoop\Php\ReverseArray;
use Eightfold\Shoop\Php\ReverseString;

use Eightfold\Shoop\Php\SplitStringOn;

use Eightfold\Shoop\Php\StartsWithString;

use Eightfold\Shoop\Php\StrippedFromString;

use Eightfold\Shoop\Php\TagsStrippedFromString;

use Eightfold\Shoop\Php\ToStringFromArray;
use Eightfold\Shoop\Php\ToStringFromArrayGlue;

// TODO: Divide this up into separate classes - probaly matching the interfaces??
//      - Arrayable
//      - Typeable
class Php
{
// -> Array
    static public function arrayWithoutEmpties(array $payload): array
    {
        // TODO: Make pipeline
        $array = array_filter($payload);
        return array_values($array);
    }

    static public function arrayReversed(
        array $payload,
        bool $preserveMembers = true
    ): array
    {
        return (new Pipeline())
            ->pipe(new ReverseArray($preserveMembers))
            ->process($payload);
    }

    static public function arrayToBool(array $payload): bool
    {
        return self::arrayToInt($payload) !== 0;
    }

    static public function arrayToInt(array $payload): int
    {
        return count($payload);
    }

    static public function arrayToJson(array $payload): string
    {
        $object = self::arrayToObject($payload);
        $json = json_encode($object);
        return $json;
    }

    static public function arrayToObject(array $payload): object
    {
        $array = self::arrayToDictionary($payload);
        return (object) $array;
    }

    static public function arrayToString(
        array $payload,
        string $glue = ""
    ): string
    {
        return (new Pipeline())
            ->pipe(new ToStringFromArray($glue))
            ->process($payload);
    }

    static public function arrayToDictionary(array $payload): array
    {
        $array = [];
        foreach ($payload as $member => $value) {
            $member = "i". $member;
            $array[$member] = $value;
        }
        return $array;
    }

    // TODO: PHP 8.0 - test directly
    static public function arraySetOffset(
        array $payload,
        int $offset = 0,
        $value = ""
    ): array
    {
        $payload[$offset] = $value;
        return $payload;
    }

    static public function arrayStripOffset(
        array $payload,
        int $offset = 0
    ): array
    {
        unset($payload[$offset]);
        return $payload;
    }

    static public function arrayIsDictionary(array $payload): bool
    {
        $members = array_keys($payload);
        $firstMember = array_shift($members);
        return is_string($firstMember) and ! is_int($firstMember);
    }

// -> Boolean
    static public function booleanToArray(bool $payload): array
    {
        return [$payload];
    }

    static public function booleanToDictionary(bool $payload): array
    {
        return ($payload === true)
            ? ["true" => true, "false" => false]
            : ["true" => false, "false" => true];
    }

    static public function booleanToInteger(bool $payload): int
    {
        return (int) $payload;
    }

    // TODO: Consider moving JSON to Shoop Extras
    static public function booleanToJson(bool $payload): string
    {
        $object = self::booleanToObject($payload);
        $json = self::objectToJson($object);
        return $json;
    }

    static public function booleanToObject(bool $payload): object
    {
        return (object) self::booleanToDictionary($payload);
    }

    static public function booleanToString(bool $payload): string
    {
        return ($payload) ? "true" : "false";
    }

// -> Dictionary
    static public function dictionaryToArray(array $payload): array
    {
        return (self::arrayIsDictionary($payload))
            ? array_values($payload)
            : [];
    }

    static public function dictionaryToBool(array $payload): bool
    {
        return self::arrayToBool($payload);
    }

    static public function dictionaryToInt(array $payload): int
    {
        return self::arrayToInt($payload);
    }

    static public function dictionaryToJson(array $payload): string
    {
        $object = self::dictionaryToObject($payload);
        return self::objectToJson($object);
    }

    static public function dictionaryToObject(array $payload): object
    {
        return (self::arrayIsDictionary($payload))
            ? (object) $payload
            : new stdClass;
    }

    static public function dictionaryToString(array $payload, string $glue = ""): string
    {
        return self::arrayToString($payload, $glue);
    }

// -> Integer
    static public function integerToArray(int $payload, int $start = 0): array
    {
        return ($start > $int)
            ? range($payload, $start)
            : range($start, $payload);
    }

    static public function integerToBool(int $payload): bool
    {
        return (bool) $payload;
    }

    static public function integerToDictionary(int $payload): array
    {
        $array = self::integerToArray($payload);
        return self::arrayToDictionary($array);
    }

    static public function integerToJson(int $payload): string
    {
        $object = self::integerToObject($payload);
        return self::objectToJson($object);
    }

    static public function integerToObject(int $payload): object
    {
        $array = self::integerToDictionary($payload);
        return self::dictionaryToObject($array);
    }

    static public function integerToString(int $payload): string
    {
        return (string) $payload;
    }

// -> JSON
    static public function jsonToArray(string $payload): array
    {
        if (! self::stringIsJson($payload)) {
            return "";
        }
        $object = self::jsonToObject($payload);
        return self::objectToArray($object);
    }

    static public function jsonToBool(string $payload): bool
    {
        if (! self::stringIsJson($payload)) {
            return false;
        }
        $object = self::jsonToObject($payload);
        return self::objectToBool($object);
    }

    static public function jsonToDictionary(string $payload): array
    {
        if (! self::stringIsJson($payload)) {
            return [];
        }
        $object = self::jsonToObject($payload);
        return self::objectToDictionary($object);
    }

    static public function jsonToInt(string $payload): int
    {
        if (! self::stringIsJson($payload)) {
            return 0;
        }
        $object = self::jsonToObject($payload);
        return self::objectToInt($object);
    }

    static public function jsonToObject(string $payload): object
    {
        if (! self::stringIsJson($payload)) {
            return new stdClass;
        }
        return json_decode($payload);
    }

// -> Object
    static public function objectToArray(object $payload): array
    {
        $array = self::objectToDictionary($payload);
        $array = array_values($array);
        return $array;
    }

    static public function objectToBool(object $payload): bool
    {
        return self::objectToInt($payload) > 0;
    }

    static public function objectToDictionary(object $payload): array
    {
        return (array) $payload;
    }

    static public function objectToInt(object $payload): int
    {
        $array = self::objectToDictionary($payload);
        return count($array);
    }

    static public function objectToJson(object $payload): string
    {
        return json_encode($payload);
    }

    static public function objectToString(object $payload): string
    {
        if (method_exists($payload, "__toString")) {
            return (string) $payload;
        }

        $array = self::objectToDictionary($payload);
        $string = self::dictionaryToString($array);
        return $string;
    }

// -> String
    static public function stringIsJson(string $payload): bool
    {
        if (! self::stringStartsWith($payload, "{")) {
            return false;
        }

        if (! self::stringEndsWith($payload, "}")) {
            return false;
        }

        if (! is_array(json_decode($payload, true))) {
            return false;
        }

        return json_last_error() === JSON_ERROR_NONE;
    }

    static public function stringToObject(string $payload): object
    {
        return (object) ["string" => $payload];
    }

    static public function stringToInt(string $payload): int
    {
        return strlen($payload);
    }

    static public function stringSplitOn(
        string $payload,
        string $splitter       = "",
        bool   $includeEmpties = true,
        int    $limit          = PHP_INT_MAX
    ): array
    {
        return (new Pipeline())
            ->pipe(new SplitStringOn($splitter, $includeEmpties, $limit))
            ->process($payload);
    }

    static public function stringHasOffset(
        string $payload,
        int $offset = 0
    ): bool
    {
        return isset($payload[$offset]);
    }

    static public function stringGetOffset(
        string $payload,
        int $offset = 0
    ): string
    {
        return (static::stringHasOffset($payload, $offset))
            ? $payload[$offset]
            : "";
    }

    static public function stringSetOffset(
        string $payload,
        int $offset   = 0,
        string $value = ""
    ): string
    {
        $array = static::stringToArray($payload);
        $array = static::arraySetOffset($array, $offset, $value);
        return static::arrayToString($array);
    }

    static public function stringStripOffset(string $payload, int $offset = 0)
    {
        $array = static::stringToArray($payload);
        $array = static::arrayStripOffset($array, $offset);
        return static::arrayToString($array);
    }

    static public function stringAppendedWith(
        string $payload,
        string ...$terms
    ): string
    {
        $string = $payload;
        foreach ($terms as $term) {
            $string .= $term;
        }
        return $string;
    }

    static public function stringRepeated(
        string $payload,
        int $multiplier = 1
    ): string
    {
        return str_repeat($payload, $multiplier);
    }

    static public function stringAfterReplacing(
        string $payload,
        array  $replacements,
        bool   $caseSensitive = true
    ): string
    {
        $search = array_keys($replacements);
        $replace = array_values($replacements);
        $string = ($caseSensitive)
            ? str_replace($search, $replace, $payload)
            : str_ireplace($search, $replace, $payload);
        return $string;
    }

    static public function stringStrippedOfFirst(
        string $payload,
        int $length = 1
    ): string
    {
        $sLength = strlen($payload) - $length;
        return substr($payload, $length, $sLength);
    }

    static public function stringStrippedOfLast(
        string $payload,
        int $length = 1
    ): string
    {
        $sLength = strlen($payload) - $length;
        return substr($payload, 0, $sLength);
    }

    static public function stringStrippedOfTags(
        string $payload,
        string ...$allowed
    ): string
    {
        return (new Pipeline())
            ->pipe(new TagsStrippedFromString(...$allowed))
            ->process($payload);
    }

    static public function stringStrippedOf(
        string $payload,
        bool   $fromEnd     = true,
        bool   $fromStart   = true,
        string $charMask    = " \t\n\r\0\x0B"
    ): string
    {
        return (new Pipeline())
            ->pipe(new StrippedFromString($fromEnd, $fromStart, $charMask))
            ->process($payload);
    }

    static public function stringEndsWith(string $payload, string $suffix): bool
    {
        return (new Pipeline())
            ->pipe(new EndsWithString($suffix))
            ->process($payload);
    }

    static public function stringStartsWith(
        string $payload,
        string $prefix
    ): bool
    {
        return (new Pipeline())
            ->pipe(new StartsWithString($prefix))
            ->process($payload);
    }

    static public function stringReversed(string $payload): string
    {
        return Shoop::pipeline($payload, ReverseString::bend())->unfold();
    }

    static public function stringToLowercaseFirst(string $payload): string
    {
        return lcfirst($payload);
    }

    static public function stringToLowercase(string $payload): string
    {
        return mb_strtolower($payload);
    }

    static public function stringToUppercase(string $payload): string
    {
        return mb_strtoupper($payload);
    }

    static public function stringToArray(string $payload): array
    {
        return Shoop::pipeline($payload, ToArrayFromString::bend())->unfold();
    }
}
