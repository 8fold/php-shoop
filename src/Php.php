<?php
declare(strict_types=1);

namespace Eightfold\Shoop;

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

class Php
{
// -> Array
    static public function arrayWithoutEmpties(array $payload): array
    {
        // TODO: Make pipeline
        $array = array_filter($payload);
        return array_values($array);
    }

    static public function arrayReversed(array $payload): array
    {
        return (new Pipeline())
            ->pipe(new ReverseArray)
            ->process($payload);
    }

    static public function arrayToString(
        array $payload,
        string $glue = ""
    ): string
    {
        $payload = ["array" => $payload, "glue" => $glue];
        return (new Pipeline())
            ->pipe(new ToStringFromArray)
            ->process($payload);
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

// -> JSON
    static public function objectToJson(object $payload): string
    {
        return json_encode($payload);
    }

// -> String
    static public function stringToObject(string $payload): objet
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
        $payload = [
            "string"         => $payload,
            "splitter"       => $splitter,
            "includeEmpties" => $includeEmpties,
            "limit"          => $limit
        ];
        return (new Pipeline())
            ->pipe(new SplitStringOn)
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
        $payload = ["string" => $payload, "allowed" => $allowed];
        return (new Pipeline())
            ->pipe(new TagsStrippedFromString)
            ->process($payload);
    }

    static public function stringStrippedOf(
        string $payload,
        bool   $fromEnd     = true,
        bool   $fromStart   = true,
        string $charMask    = " \t\n\r\0\x0B"
    ): string
    {
        $payload = [
            "string"    => $payload,
            "charsMask" => $charMask,
            "fromEnd"   => $fromEnd,
            "fromStart" => $fromStart
        ];
        return (new Pipeline())
            ->pipe(new StrippedFromString)
            ->process($payload);
    }

    static public function stringEndsWith(string $payload, string $suffix): bool
    {
        $payload = ["string" => $payload, "suffix" => $suffix];
        return (new Pipeline())
            ->pipe(new EndsWithString)
            ->process($payload);
    }

    static public function stringStartsWith(
        string $payload,
        string $prefix
    ): bool
    {
        $payload = ["string" => $payload, "prefix" => $prefix];
        return (new Pipeline())
            ->pipe(new StartsWithString)
            ->process($payload);
    }

    static public function stringReversed(string $payload): string
    {
        return (new Pipeline())
            ->pipe(new ReverseString)
            ->process($payload);
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
        $pipeline = (new Pipeline())->pipe(new ToArrayFromString);
        return $pipeline->process($payload);
    }
}
