<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Interfaces\Shooped;

use Eightfold\Shoop\{
    Shoop,
    ESBool,
    ESInt,
    ESString,
    ESArray,
    ESObject
};

class Type
{
    static public function map(): array
    {
        return [
            ESBool::class   => "boolean",
            ESInt::class    => "integer",
            ESString::class => "string",
            ESArray::class  => "array",
            ESObject::class => "object"
        ];
    }

    static public function phpToShoop(string $phpType): string
    {
        if ($phpType === "bool") {
            $phpType = "boolean";

        } elseif ($phpType === "int") {
            $phpType = "integer";

        }

        $phpMap = array_flip(static::map());
        if (array_key_exists($phpType, $phpMap)) {
            return $phpMap[$phpType];
        }
        return "";
    }

    static public function shoopToPhp(string $shoopType): string
    {
        $shoopMap = static::map();
        if (array_key_exists($shoopType, $shoopMap)) {
            $value = $shoopMap[$shoopType];
            if ($value === "boolean") {
                $value = "bool";

            } elseif ($value === "integer") {
                $value = "int";

            }
            return $value;
        }
        return "";
    }

    static public function for($potential): string
    {
        if (static::isShooped($potential)) {
            return get_class($potential);
        }

        $type = gettype($potential);
        if ($type === "integer") {
            $type = "int";

        } elseif ($type === "boolean") {
            $type = "bool";

        }
        return $type;
    }

    static public function isShooped($potential): bool
    {
        return $potential instanceOf Shooped;
    }

    static public function isNotShooped($potential)
    {
        return ! static::isShooped($potential);
    }

    static public function isPhp($potential): bool
    {
        if (static::isShooped($potential)) {
            return false;
        }

        $phpTypes = array_values(static::map());
        return in_array(static::for($potential), $phpTypes);
    }

    static public function isNotPhp($potential): bool
    {
        return ! static::isPhp($potential);
    }

    static public function isArray($potential): bool
    {
        return is_array($value)
            || (self::valueIsShooped($value) && is_a($value, ESArray::class));
    }

    static public function isNotArray($potential): bool
    {
        return ! static::isArray($potential);
    }

    static public function isDictionary($potential): bool
    {
        if (static::isArray($potential)) {
            return array_keys($value) !== range(0, count($value) - 1);
        }
    }
}
