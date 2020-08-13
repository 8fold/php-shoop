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

use Eightfold\Shoop\Php\Reverse;

use Eightfold\Shoop\Php\SplitStringOn;

use Eightfold\Shoop\Php\StartsWithString;

use Eightfold\Shoop\Php\StringFromString;
use Eightfold\Shoop\Php\StringIsJson;

use Eightfold\Shoop\Php\StrippedFromString;

use Eightfold\Shoop\Php\AsArrayFromInteger;
use Eightfold\Shoop\Php\AsArrayFromObject;
use Eightfold\Shoop\Php\AsArrayFromString;
use Eightfold\Shoop\Php\AsArrayFromJson;

use Eightfold\Shoop\Php\AsDictionary;
use Eightfold\Shoop\Php\AsDictionaryFromArray;
use Eightfold\Shoop\Php\AsDictionaryFromInteger;
use Eightfold\Shoop\Php\AsDictionaryFromBoolean;
use Eightfold\Shoop\Php\AsDictionaryFromObject;

use Eightfold\Shoop\Php\AsInt;
use Eightfold\Shoop\Php\AsIntegerFromArray;
use Eightfold\Shoop\Php\AsIntegerFromString;

use Eightfold\Shoop\Php\AsJsonFromObject;

use Eightfold\Shoop\Php\AsStringFromArray;
use Eightfold\Shoop\Php\AsStringFromObject;
use Eightfold\Shoop\Php\AsStringWithTags;

use Eightfold\Shoop\Php\AsObjectFromArray;
use Eightfold\Shoop\Php\AsObjectFromJson;

use Eightfold\Shoop\Php\ValuesFromArray;

// TODO: Divide this up into separate classes - probaly matching the interfaces??
//      - Arrayable
//      - Typeable
class Php
{
// -> Array
    // TODO: Test directly
    static public function arraySetOffset(
        array $payload,
        int $offset = 0,
        $value = ""
    ): array
    {
        return Shoop::pipe($payload,
            SetOffsetForArray::apply($value, $offset)
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
        return Shoop::pipe($payload,
            StripOffsetFromArray::applyWith($offset)
        )->unfold();
        // unset($payload[$offset]);
        // return $payload;
    }

// -> Dictionary

// -> Integer

// -> JSON

// -> Object
    static public function objectToBool(object $payload): bool
    {
        return Shoop::pipe($payload,
            AsDictionary::apply(),
            AsInt::apply(),
            IntegerIsGreaterThan::applyWith(0)
        )->unfold();
    }

    static public function objectToInt(object $payload): int
    {
        return Shoop::pipe($payload,
            AsDictionary::apply(),
            AsInt::apply()
        )->unfold();
    }

// -> String
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
        return Shoop::pipe($payload,
            AsArrayFromString::apply(),
            StripArrayAt::applyWith($offset),
            ToStringFromArray::apply()
        )->unfold();
    }

    // static public function stringAppendedWith(
    //     string $payload,
    //     string ...$terms
    // ): string
    // {
    //     $string = $payload;
    //     foreach ($terms as $term) {
    //         $string .= $term;
    //     }
    //     return $string;
    // }

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
        return Shoop::pipe($payload,
            AsStringWithTags::applyWith(...$allowed)
        )->unfold();
    }

    static public function stringStrippedOf(
        string $payload,
        bool   $fromEnd     = true,
        bool   $fromStart   = true,
        string $charMask    = " \t\n\r\0\x0B"
    ): string
    {
        return Shoop::pipe($payload,
            StrippedFromString::applyWith($fromEnd, $fromStart, $charMask)
        )->unfold();
    }

    static public function stringReversed(string $payload): string
    {
        return Shoop::pipe($payload, Reverse::apply())->unfold();
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
        return Shoop::pipe($payload, EndsWithString::applyWith($suffix))
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
        return Shoop::pipe($payload, StartsWithString::applyWith($prefix))
            ->unfold();
    }

    /**
     * @deprecated
     */
    static public function stringToArray(string $payload): array
    {
        return Shoop::pipe($payload, AsArrayFromString::apply())->unfold();
    }

    /**
     * @deprecated
     */
    static public function arrayReversed(
        array $payload,
        bool $preserveMembers = true
    ): array
    {
        return Shoop::pipe($payload,
            ReverseArray::applyWith($preserveMembers)
        )->unfold();
    }
}
