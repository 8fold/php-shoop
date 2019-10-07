<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Interfaces\Shooped;

class Shoop
{
    static public function int($int): ESInt
    {
        return ESInt::fold($int);
    }

    static public function string($string): ESString
    {
        return ESString::fold($string);
    }

    static public function array($array): ESArray
    {
        return ESArray::fold($array);
    }

    static public function dictionary($assocArray)
    {
        return ESDictionary::fold($assocArray);
    }

    static public function range($min, $max, $includeLast = true): ESRange
    {
        return ESRange::fold($min, $max, $includeLast);
    }

    static public function bool($bool): ESBool
    {
        return ESBool::fold($bool);
    }

    // static public function phpTypeForShoopType(string $shoopType): string
    // {
    //     $types = static::typeMap();
    //     if (array_key_exists($shoopType, static::typeMap())) {
    //         return $types[$shoopType];
    //     }
    //     return "";
    // }

    // static public function typeMap(): array
    // {
    //     return [
    //         ESBool::class   => "boolean",
    //         ESInt::class    => "integer",
    //         ESInt::class    => "int",
    //         ESString::class => "string",
    //         ESArray::class  => "array",
    //         ESObject::class => "object"
    //     ];
    // }

    // static public function shoopTypeForValue($value)
    // {
    //     if (Shoop::valueIsShooped($value)) {
    //         return get_class($value);
    //     }
    //     $phpTypes = array_flip(static::typeMap());
    //     $phpType = static::phpTypeForValue($value);
    //     return $phpTypes[$phpType];
    // }

    // static public function phpTypeForValue($value)
    // {
    //     $type = gettype($value);
    //     if ($type === "integer") {
    //         $type = "int";
    //     }
    //     return $type;
    // }

    // static public function valueIsPhpType($potential): bool
    // {
    //     if (Shoop::valueIsShooped($potential)) {
    //         return false;
    //     }

    //     $types = static::typeMap();
    //     $phpTypes = array_values($types);
    //     $phpType = Shoop::phpTypeForValue($potential);

    //     return in_array($phpType, $phpTypes);
    // }

    // static public function valueIsShooped($potential): bool
    // {
    //     return $potential instanceOf Shooped;
    // }

    // static public function valueIsNotShooped($potential): bool
    // {
    //     return ! self::valueIsShooped($potential);
    // }

    // static public function valueIsSubclass($value, string $className)
    // {
    //     # code...
    // }

    // static public function valueIsNotSubclass($value, string $className)
    // {
    //     # code...
    // }

    // static public function valueIsClass($value, string $className)
    // {
    //     # code...
    // }

    // static public function valueIsNotClass($value, string $className)
    // {
    //     # code...
    // }

    // static public function valueIsArray($value)
    // {
    //     return is_array($value) || (self::valueIsShooped($value) && is_a($value, ESArray::class));
    // }

    // static public function valueIsNotArray($value)
    // {
    //     return ! self::valueIsArray($value);
    // }

    // static public function valueIsDictionary($value): bool
    // {
    //     if (is_array($value)) {
    //         return array_keys($value) !== range(0, count($value) - 1);
    //     }
    //     return false;
    // }
}
