<?php
declare(strict_types=1);

namespace Eightfold\Shoop;

use \stdClass;

use League\Pipeline\Pipeline;

use Eightfold\Shoop\Php\ArrayFromBoolean;

use Eightfold\Shoop\Php\ArrayIsDictionary;

use Eightfold\Shoop\Php\BooleanFromArray;

use Eightfold\Shoop\Php\DivideString;

use Eightfold\Shoop\Php\EndsWithString;

use Eightfold\Shoop\Php\EqualStrings;

use Eightfold\Shoop\Php\IntegerIsGreaterThan;

use Eightfold\Shoop\Php\ReverseArray;
use Eightfold\Shoop\Php\ReverseString;

use Eightfold\Shoop\Php\SplitStringOn;

use Eightfold\Shoop\Php\StartsWithString;

use Eightfold\Shoop\Php\StringFromString;
use Eightfold\Shoop\Php\StringIsJson;

use Eightfold\Shoop\Php\StrippedFromString;

use Eightfold\Shoop\Php\TagsStrippedFromString;

use Eightfold\Shoop\Php\ToArrayFromInteger;
use Eightfold\Shoop\Php\ToArrayFromObject;
use Eightfold\Shoop\Php\ToArrayFromString;
use Eightfold\Shoop\Php\ToArrayFromJson;

use Eightfold\Shoop\Php\ToDictionaryFromArray;
use Eightfold\Shoop\Php\ToDictionaryFromInteger;
use Eightfold\Shoop\Php\ToDictionaryFromBoolean;
use Eightfold\Shoop\Php\ToDictionaryFromObject;

use Eightfold\Shoop\Php\ToIntegerFromArray;
use Eightfold\Shoop\Php\ToIntegerFromString;

use Eightfold\Shoop\Php\ToJsonFromObject;

use Eightfold\Shoop\Php\ToStringFromArray;
use Eightfold\Shoop\Php\ToStringFromObject;

use Eightfold\Shoop\Php\ToObjectFromArray;
use Eightfold\Shoop\Php\ToObjectFromJson;

use Eightfold\Shoop\Php\ValuesFromArray;

// TODO: Divide this up into separate classes - probaly matching the interfaces??
//      - Arrayable
//      - Typeable
class Php
{
// -> Array
    static public function arrayToJson(array $payload): string
    {
        $object = Shoop::pipeline($payload, ToObjectFromArray::bend())->unfold();
        $json = json_encode($object);
        return $json;
    }

    // TODO: Test directly
    static public function arraySetOffset(
        array $payload,
        int $offset = 0,
        $value = ""
    ): array
    {
        return Shoop::pipeline($payload,
            SetOffsetForArray::bend($value, $offset)
        )->unfold();
        // $payload[$offset] = $value;
        // return $payload;
    }

    // TODO: Test directly
    static public function arrayStripOffset(
        array $payload,
        int $offset = 0
    ): array
    {
        return Shoop::pipeline($payload,
            StripOffsetFromArray::bendWith($offset)
        )->unfold();
        // unset($payload[$offset]);
        // return $payload;
    }

// -> Boolean

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
        $isDict = Shoop::pipeline($payload, ArrayIsDictionary::bend())->unfold();
        return ($isDict)
            ? Shoop::pipeline($payload, ValuesFromArray::bend())->unfold()
            : [];
    }

    static public function dictionaryToJson(array $payload): string
    {
        return Shoop::pipeline($payload,
            ToObjectFromArray::bend(),
            ToJsonFromObject::bend()
        )->unfold();
    }

    static public function dictionaryToObject(array $payload): object
    {
        $isDict = Shoop::pipeline($payload, ArrayIsDictionary::bend())->unfold();
        return ($isDict) ? (object) $payload : new stdClass;
    }

// -> Integer

    static public function integerToBool(int $payload): bool
    {
        return (bool) $payload;
    }

    static public function integerToJson(int $payload): string
    {
        $object = self::integerToObject($payload);
        return Shoop::pipeline($object, ToJsonFromObject::bend())->unfold();
    }

    static public function integerToObject(int $payload): object
    {
        $array = self::integerToDictionary($payload);
        return Shoop::pipeline($array, ToObjectFromArray::bend())->unfold();
    }

    static public function integerToString(int $payload): string
    {
        return (string) $payload;
    }

// -> JSON
    static public function jsonToBool(string $payload): bool
    {
        $object = Shoop::pipeline($payload, ToObjectFromJson::bend())->unfold();
        return self::objectToBool($object);
    }

    static public function jsonToDictionary(string $payload): array
    {
        $object = Shoop::pipeline($payload, ToObjectFromJson::bend())->unfold();
        return self::objectToDictionary($object);
    }

    static public function jsonToInt(string $payload): int
    {
        $object = Shoop::pipeline($payload, ToObjectFromJson::bend())->unfold();
        return self::objectToInt($object);
    }

// -> Object
    static public function objectToBool(object $payload): bool
    {
        return Shoop::pipeline($payload,
            ToDictionaryFromObject::bend(),
            ToIntegerFromArray::bend(),
            IntegerIsGreaterThan::bendWith(0)
        )->unfold();
    }

    static public function objectToDictionary(object $payload): array
    {
        return (array) $payload;
    }

    static public function objectToInt(object $payload): int
    {
        return Shoop::pipeline($payload,
            ToDictionaryFromObject::bend(),
            ToIntegerFromArray::bend()
        )->unfold();
    }

// -> String
    static public function stringToObject(string $payload): object
    {
        return (object) ["string" => $payload];
    }

    static public function stringSplitOn(
        string $payload,
        string $splitter       = "",
        bool   $includeEmpties = true,
        int    $limit          = PHP_INT_MAX
    ): array
    {
        return Shoop::pipeline($payload,
            ToArrayFromString::bendWith($splitter, $includeEmpties, $limit)
        )->unfold();
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

    /**
     * @untested
     */
    static public function stringStripOffset(string $payload, int $offset = 0)
    {
        return Shoop::pipeline($payload,
            ToArrayFromString::bend(),
            StripArrayAt::bendWith($offset),
            ToStringFromArray::bend()
        )->unfold();
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
        return Shoop::pipeline($payload,
            TagsStrippedFromString::bendWith(...$allowed)
        )->unfold();
    }

    static public function stringStrippedOf(
        string $payload,
        bool   $fromEnd     = true,
        bool   $fromStart   = true,
        string $charMask    = " \t\n\r\0\x0B"
    ): string
    {
        return Shoop::pipeline($payload,
            StrippedFromString::bendWith($fromEnd, $fromStart, $charMask)
        )->unfold();
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

// -> deprecated
    /**
     * @deprecated
     */
    static public function stringEndsWith(string $payload, string $suffix): bool
    {
        return Shoop::pipeline($payload, EndsWithString::bendWith($suffix))
            ->unfold();
    }

    /**
     * @deprecated
     */
    static public function stringStartsWith(
        string $payload,
        string $prefix
    ): bool
    {
        return Shoop::pipeline($payload, StartsWithString::bendWith($prefix))
            ->unfold();
    }

    /**
     * @deprecated
     */
    static public function stringToArray(string $payload): array
    {
        return Shoop::pipeline($payload, ToArrayFromString::bend())->unfold();
    }

    /**
     * @deprecated
     */
    static public function stringIsJson(string $payload): bool
    {
        return Shoop::pipeline($payload, StringIsJson::bend())->unfold();
    }

    /**
     * @deprecated
     */
    static public function stringToInt(string $payload): int
    {
        return Shoop::pipeline($payload, ToIntegerFromString::bend())->unfold();
    }

    /**
     * @deprecated
     */
    static public function jsonToObject(string $payload): object
    {
        return Shoop::pipeline($payload, ToObjectFromJson::bend())->unfold();
    }

    /**
     * @deprecated
     */
    static public function objectToString(object $payload): string
    {
        return Shoop::pipeline($payload,
            ToStringFromObject::bend()
        )->unfold();
    }

    /**
     * @deprecated
     */
    static public function objectToArray(object $payload): array
    {
        return Shoop::pipeline($payload, ToArrayFromObject::bend())->unfold();
    }

    /**
     * @deprecated
     */
    static public function jsonToArray(string $payload): array
    {
        return Shoop::pipeline($payload, ToArrayFromJson::bend())->unfold();
    }

    /**
     * @deprecated
     */
    static public function integerToDictionary(int $payload): array
    {
        return Shoop::pipeline($payload, ToDictionaryFromInteger::bend())
            ->unfold();
    }

    /**
     * @deprecated
     */
    static public function integerToArray(int $payload, int $start = 0): array
    {
        return Shoop::pipeline($payload,
            ToArrayFromInteger::bend($start)
        )->unfold();
    }

    /**
     * @deprecated
     */
    static public function objectToJson(object $payload): string
    {
        return Shoop::pipeline($payload, ToJsonFromObject::bend())->unfold();
    }

    /**
     * @deprecated
     */
    static public function dictionaryToString(array $payload, string $glue = ""): string
    {
        return Shoop::pipeline($payload, ToStringFromArray::bendWith($glue))
            ->unfold();
    }

    /**
     * @deprecated
     */
    static public function dictionaryToBool(array $payload): bool
    {
        return Shoop::pipeline($payload,
            BooleanFromArray::bend()
        )->unfold();
    }

    /**
     * @deprecated
     */
    static public function dictionaryToInt(array $payload): int
    {
        return Shoop::pipeline($payload, ToIntegerFromArray::bend())->unfold();
    }

    /**
     * @deprecated
     */
    static public function booleanToArray(bool $payload): array
    {
        return Shoop::pipeline($payload, ArrayFromBoolean::bend())->unfold();
    }

    /**
     * @deprecated
     */
    static public function booleanToDictionary(bool $payload): array
    {
        return Shoop::pipeline($payload, ToDictionaryFromBoolean::bend())
            ->unfold();
    }

    /**
     * @deprecated
     */
    static public function arrayIsDictionary(array $payload): bool
    {
        return Shoop::pipeline($payload, ArrayIsDictionary::bend())->unfold();
    }

    /**
     * @deprecated
     */
    static public function arrayToString(
        array $payload,
        string $glue = ""
    ): string
    {
        return Shoop::pipeline($payload, ToStringFromArray::bendWith($glue))
            ->unfold();
    }

    /**
     * @deprecated
     */
    static public function arrayToDictionary(array $payload): array
    {
        return Shoop::pipeline($payload, ToDictionaryFromArray::bend())
            ->unfold();
    }

    /**
     * @deprecated
     */
    // static public function arrayWithoutEmpties(array $payload): array
    // {
    //     return Shoop::pipeline($payload, StripEmptiesFromArray::bend())
    //         ->unfold();
    // }

    /**
     * @deprecated
     */
    static public function arrayReversed(
        array $payload,
        bool $preserveMembers = true
    ): array
    {
        return Shoop::pipeline($payload,
            ReverseArray::bendWith($preserveMembers)
        )->unfold();
    }
}
