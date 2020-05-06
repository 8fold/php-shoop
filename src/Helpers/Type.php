<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Interfaces\Shooped;

use Eightfold\Shoop\{
    Shoop,
    ESBool,
    ESInt,
    ESString,
    ESArray,
    ESDictionary,
    ESObject,
    ESJson
};

class Type
{
    static public function sanitizeType($toSanitize, string $shoopType = "")
    {
        if (self::isShooped($toSanitize)) {
            return $toSanitize;
        }

        $sanitizeType = self::shoopFor($toSanitize);
        $shooped = $sanitizeType::fold($toSanitize);
        switch ($shoopType) {
            case ESArray::class:
                return $shooped->array();
                break;

            case ESBool::class:
                return $shooped->bool();
                break;

            case ESDictionary::class:
                return $shooped->dictionary();
                break;

            case ESInt::class:
                return $shooped->int();
                break;

            case ESJson::class:
                return $shooped->json();
                break;

            case ESObject::class:
                return $shooped->object();
                break;

            case ESString::class:
                return $shooped->string();
                break;

            default:
                return $shooped;
                break;
        }
    }

    static private function isDesiredTypeOrTriggerError($desiredPhpType, $variable)
    {
        $sanitizeType = self::for($variable);
        if ($sanitizeType !== $desiredPhpType) {
            list($_, $caller) = debug_backtrace(false);
            self::invalidTypeError($desiredPhpType, $sanitizeType, $caller);
        }
    }

    static private function invalidTypeError($desiredPhpType, $sanitizeType, $caller)
    {
        $className = $caller['class'];
        $functionName = $caller['function'];
        $myClass = static::class;
        trigger_error(
            "Argument 1 passed to {$functionName} in {$className} must be of type {$desiredPhpType} or an instance of {$myClass} received {$sanitizeType} instead",
            E_USER_ERROR
        );
    }

    static public function is($potential, string ...$types): bool
    {
        $potentialType = self::for($potential);
        foreach ($types as $type) {
            if ($potentialType === $type) {
                return true;
            }
        }
        return false;
    }

    static public function for($potential): string
    {
        if (static::isShooped($potential)) {
            return get_class($potential);
        }

        $type = gettype($potential);

        if ($type === "object" && ! is_a($potential, \stdClass::class)) {
            return get_class($potential);
        }

        if ($type === "integer") {
            $type = "int";

        } elseif ($type === "boolean") {
            $type = "bool";

        } elseif (self::isJson($potential)) {
            $type = "json";

        } elseif ($type === "array" && self::isDictionary($potential)) {
            $type = "dictionary";

        }
        return $type;
    }

    static public function shoopFor($potential)
    {
        if (static::isShooped($potential)) {
            return get_class($potential);
        }

        if (self::isArray($potential)) {
            return ESArray::class;

        } elseif (self::isBool($potential)) {
            return ESBool::class;

        } elseif (self::isDictionary($potential)) {
            return ESDictionary::class;

        } elseif (self::isInt($potential)) {
            return ESInt::class;

        } elseif (self::isJson($potential)) {
            return ESJson::class;

        } elseif (self::isObject($potential)) {
            return ESObject::class;

        } elseif (self::isString($potential)) {
            return ESString::class;

        }
        // return self::phpToShoop(self::for($potential));
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
        if (self::isShooped($potential)) {
            return false;
        }

        $custom = (is_string($potential)) ? explode("\\", $potential) : $potential;
        if (is_array($custom) && count($custom) > 1) {
            return false;
        }

        if (is_object($potential) && ! is_a($potential, \stdClass::class)) {
            return false;
        }

        $phpTypes = array_keys(self::map());
        array_pop($phpTypes);
        if (in_array(gettype($potential), $phpTypes)) {
            return true;
        }

        return false;
    }

    static public function isNotPhp($potential): bool
    {
        return ! static::isPhp($potential);
    }

    static public function isArray($potential): bool
    {
        if (! is_array($potential)) {
            return false;

        } elseif (is_array($potential) && count($potential) === 0) {
            return true;

        } elseif (self::isShooped($potential) && ! is_a($potential, ESArray::class)) {
            return false;

        } elseif (self::isShooped($potential) && is_a($potential, ESArray::class)) {
            return true;

        } elseif (is_array($potential)) {
            $keys = array_keys($potential);
            $firstKey = array_shift($keys);
            if (is_int($firstKey)) {
                return true;

            } elseif (is_string($firstKey)) {
                return false;

            }
        }
        return false;
    }

    static public function isNotArray($potential): bool
    {
        return ! static::isArray($potential);
    }

    static public function isBool($potential): bool
    {
        return is_bool($potential);
    }

    static public function isNotBool($potential): bool
    {
        return ! self::isBool($potential);
    }

    static public function isDictionary($potential): bool
    {
        if (! is_array($potential)) {
            return false;

        } elseif (is_array($potential) && count($potential) === 0) {
            return false;

        } elseif (self::isShooped($potential) && ! is_a($potential, ESDictionary::class)) {
            return false;

        } elseif (Self::isShooped($potential) && is_a($potential, ESDictionary::class)) {
            return true;

        } elseif (is_array($potential)) {
            $keys = array_keys($potential);
            $firstKey = array_shift($keys);
            if (is_int($firstKey)) {
                return false;

            } elseif (is_string($firstKey)) {
                return true;

            }
        }
        return false;
    }

    static public function isNotDictionary($potential): bool
    {
        return ! self::isDictionary($potential);
    }

    static public function isInt($potential): bool
    {
        return is_int($potential);
    }

    static public function isNotint($potential): bool
    {
        return ! self::isInt($potential);
    }

    static public function isJson($potential): bool
    {
        $isString = is_string($potential);
        if ($isString) {
            // Bail as soon as possible.
            $potential = trim($potential);

            $startsWith = "{";
            $startsWithLength = strlen($startsWith);
            if (substr($potential, 0, $startsWithLength) !== $startsWith) {
                return false;
            }

            $endsWith = "}";
            $endsWithLength = strlen($endsWith);
            if (substr($potential, -$endsWithLength) !== $endsWith) {
                return false;
            }

            if (! is_array(json_decode($potential, true))) {
                return false;
            }

            $jsonError = json_last_error() !== JSON_ERROR_NONE;
            if ($jsonError) {
                return false;
            }
        }
        return $isString;
    }

    static public function isNotJson($potential): bool
    {
        return ! self::isJson($potential);
    }

    static public function isObject($potential): bool
    {
        return (is_object($potential) && self::isPhp($potential))
            || (self::isShooped($potential) && is_a($potential, ESObject::class));
    }

    static public function isNotObject($potential): bool
    {
        return ! self::isObject($potential);
    }

    static public function isString($potential): bool
    {
        return is_string($potential);
    }

    static public function isNotString($potential): bool
    {
        return ! self::isString($potential);
    }

    static public function isPath($potential): bool
    {
        return Shoop::string($potential)->hasUnfolded("/") && self::isNotUri($potential);
    }

    static public function isUri($potential): bool
    {
        $potential = Shoop::string($potential);
        return $potential->has("/")->and($potential->startsWith("http"))->unfold();
    }

    static public function isNotUri($potential)
    {
        return ! self::isUri($potential);
    }

    static public function isEmpty(Shooped $check): bool
    {
        return empty($check->unfold());
    }

    static public function map(): array
    {
        return [
            "bool"       => ESBool::class,
            "boolean"    => ESBool::class,
            "int"        => ESInt::class,
            "integer"    => ESInt::class,
            "string"     => ESString::class,
            "array"      => ESArray::class,
            "dictionary" => ESDictionary::class,
            "object"     => ESObject::class,
            "json"       => ESJson::class
        ];
    }

    static public function phpToShoop(string $phpType): string
    {
        $map = static::map();
        return (array_key_exists($phpType, $map))
            ? $map[$phpType]
            : "";
    }

    static public function shoopToPhp(string $shoopType): string
    {
        $map = static::map();
        if (in_array($shoopType, $map)) {
            $value = array_search($shoopType, $map);
            return $value;
        }
        return "";
    }
}
