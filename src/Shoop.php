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

    static public function instanceFromValue($value)
    {
        $map = Shoop::typeMap();
        $type = Shoop::typeForValue($value);
        if (! array_key_exists($type, $map) || $value === null) {
            $compareString = var_dump($compare);
            trigger_error("{$compareString} is not a supported type in Shoop. Please submit an issue or PR through GitHub: 8fold/php-shoop");
        }
        $class = $map[$type];
        return $class::fold($value);
    }

    static public function typeMap(): array
    {
        return [
            "boolean" => ESBool::class,
            "integer" => ESInt::class,
            "int"     => ESInt::class,
            "string"  => ESString::class,
            "array"   => ESArray::class,
            // "object"  => ESBaseType::class,
            "NULL"    => null
        ];
    }

    static public function typeForValue($value)
    {
        $type = gettype($value);
        if ($type === "integer") {
            $type = "int";
        }
        return $type;
    }

    static public function valueIsShooped($potential): bool
    {
        return $potential instanceOf Shooped;
    }

    static public function valueisSubclass($value, string $className)
    {
        # code...
    }

    static public function valueisNotSubclass($value, string $className)
    {
        # code...
    }

    static public function valueIsClass($value, string $className)
    {
        # code...
    }

    static public function valueIsNotClass($value, string $className)
    {
        # code...
    }

    static public function valueIsArray($value)
    {
        return is_array($value) || (self::valueIsShooped($value) && is_a($value, ESArray::class));
    }

    static public function valueIsDictionary($value): bool
    {
        if (is_array($value)) {
            return array_keys($value) !== range(0, count($value) - 1);
        }
        return false;
    }

}
